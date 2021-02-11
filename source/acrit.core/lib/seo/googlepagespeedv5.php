<?php
/**
 * Class to work with Google PageSpeed
 */

namespace Acrit\Core\Seo;

use
	\Acrit\Core\Helper,
	\Acrit\Core\HttpRequest;

class GooglePageSpeedV5 {
	
	const URL = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
	
	const MODE_DEFAULT = 0;
	const MODE_SCORE = 1;
	const MODE_CATEGORIES = 2;
	
	const AUDITS_ACTUAL = 'audits_actual';
	const AUDITS_FINISHED = 'audits_finished';
	const AUDITS_INFO = 'audits_info';
	const AUDITS_GROUP_DEFAULT = '_default';
	
	protected function __construct(){}
	
	/**
	 *	Combine 'http', 'site.ru', '/catalog/' to 'http://site.ru/catalog/'
	 */
	public static function combineUrl($strScheme, $strDomain, $strPathname){
		$strScheme = $strScheme == 'https' ? 'https://' : 'http://';
		if(!preg_match('#^/#', $strPathname)){
			$strPathname = '/'.$strPathname;
		}
		return sprintf('%s%s%s', $strScheme, $strDomain, $strPathname);
	}
	
	/**
	 *	Test single page (url) for single strategy
	 */
	public static function testUrl($strUrl, $bMobile=false, $intMode=self::MODE_DEFAULT, $arCategories=[]){
		$mResult = null;
		if(!is_numeric($intMode) || $intMode < 0){
			$intMode = static::MODE_DEFAULT;
		}
		if(!is_array($arCategories) || empty($arCategories)){
			$arCategories = [
				'performance',
				'accessibility',
				'best-practices',
				'seo',
				'pwa',
			];
		}
		$arGet = [
			'key' => static::getApiKey(),
			'url' => $strUrl,
			'strategy' => $bMobile ? 'mobile' : 'desktop',
			'locale' => 'ru_RU',
			'prettyPrint' => 'false',
			'category' => $arCategories,
		];
		$strUrl = static::httpBuildQuery($arGet);
		$intTimeout = 30;
		$strResponse = HttpRequest::get($strUrl, ['TIMEOUT' => $intTimeout]);
		if(strlen($strResponse)){
			try{
				$arJsonResponse = \Bitrix\Main\Web\Json::decode($strResponse);
			}
			catch(\Exception $obException){}
			if(is_array($arJsonResponse)){
				$mResult = $arJsonResponse;
				$mResult = static::returnModeResult($arJsonResponse, $intMode);
			}
		}
		return $mResult;
		/*
		if(is_numeric($arResponse['ruleGroups']['SPEED']['score'])) {
			$this->score = $arResponse['ruleGroups']['SPEED']['score'];
		} else {
			$this->score = false;
		}
		$arExcludedPath = array(
			'/bitrix/tools/captcha.php',
		);
		if(is_array($arImagesToOptimize)) {
			$arAllowArg = array('URL','SIZE_IN_BYTES','PERCENTAGE');
			foreach($arImagesToOptimize as $arImage){
				$arResultImage = array(
					'URL' => null,
					'SIZE_IN_BYTES' => null,
					'PERCENTAGE' => null,
					'EXTERNAL' => false,
					'NEED_RESIZE' => strpos($arImage['result']['format'],'resizing')!==false,
				);
				foreach($arImage['result']['args'] as $arArg){
					if(in_array($arArg['key'],$arAllowArg)) {
						$Value = $arArg['value'];
						$arResultImage[$arArg['key']] = $Value;
					}
				}
				$arResultImage['URL'] = urldecode($arResultImage['URL']);
				if(!(defined('BX_UTF')&&BX_UTF===true)) {
					foreach($arResultImage as $Key => $Value){
						$arResultImage[$Key] = $GLOBALS['APPLICATION']->ConvertCharset($arResultImage[$Key],'UTF-8','CP1251');
					}
				}
				$arUrl = parse_url($arResultImage['URL']);
				$strExt = ToUpper(pathinfo($arUrl['path'],PATHINFO_EXTENSION));
				$arResultImage['IS_JPG'] = $strExt=='JPG' ? 'Y' : 'N';
				$arResultImage['IS_PNG'] = $strExt=='PNG' ? 'Y' : 'N';
				if(ToLower(preg_replace('#^www\.(.*?)$#','$1',$arUrl['host']))!=ToLower(preg_replace('#^www\.(.*?)$#','$1',$this->domain))) {
					$arResultImage['EXTERNAL'] = true;
				}
				$arResultImage['EXCLUDED'] = in_array(ToLower($arUrl['path']),$arExcludedPath);
				$arResult[] = $arResultImage;
			}
		} else {
			return false;
		}
		return $arResult;
		*/
	}
	
	/**
	 *	Get API-key for Google PageSpeed
	 */
	public static function getApiKey(){
		return \Bitrix\Main\Config\Option::get(ACRIT_CORE, 'google_pagespeed_v5_apikey');
	}
	
	/**
	 *	Wrapper for http_build_query (but http_build_query cannot make url like '&category=1&category=2')
	 */
	public static function httpBuildQuery(array $arGet){
		$arCategory = $arGet['category'];
		unset($arGet['category']);
		$strQuery = http_build_query($arGet);
		if(is_array($arCategory)){
			foreach($arCategory as $strCategory){
				$strQuery .= '&category='.urlencode($strCategory);
			}
		}
		return static::URL.'?'.$strQuery;
	}
	
	/**
	 *	Return result considering $arFlags
	 */
	public static function returnModeResult(array $arJsonResponse, $intMode){
		$mResult = null;
		switch($intMode){
			case static::MODE_DEFAULT:
				$mResult = $arJsonResponse;
				break;
			case static::MODE_SCORE:
				$mResult = array_map(function($arItem){
					return array_intersect_key($arItem, array_flip(['id', 'title', 'score', 'description']));
				}, $arJsonResponse['lighthouseResult']['categories']);
				break;
			case static::MODE_CATEGORIES:
				$mResult = $arJsonResponse['lighthouseResult']['categories'];
				break;
		}
		return $mResult;
	}
	
	/**
	 *	Prepare description text to output
	 */
	public static function prepareDescriptionText($strDescription){
		$strDescription = static::prepareDescriptionTags($strDescription);
		$strDescription = static::replaceDescriptionUrls($strDescription);
		return $strDescription;
	}
	
	/**
	 *	Process with htmlspecialcharsbx (because some items contain '<div>', '<b>', ...)
	 */
	public static function prepareDescriptionTags($strDescription){
		return htmlspecialcharsbx($strDescription);
	}
	
	/**
	 *	Replace URLs in description to html:
	 *	[mixed content](https://developers.google.com/web/fundamentals/security/prevent-mixed-content/what-is-mixed-content)
	 *	[Details…](https://web.dev/is-on-https/)
	 */
	public static function replaceDescriptionUrls($strDescription){
		return preg_replace_callback('#\[(.*?)\]\((.*?)\)#i', function($arMatch){
			return sprintf('<a href="%2$s" target="_blank">%1$s</a>', $arMatch[1], $arMatch[2]);
		}, $strDescription);
	}
	
	/**
	 *	Transform lighthouse array for output
	 */
	public static function prepareResultForDisplay($arLighthouse){
		$arResult = [
			'score' => $arLighthouse['categories']['performance']['score'] * 100,
			'audits' => [],
			'screenshot' => $arLighthouse['audits']['final-screenshot']['details']['data'],
			'thumbnails' => array_column($arLighthouse['audits']['screenshot-thumbnails']['details']['items'], 'data'),
		];
		
		# Shortcuts
		$arCategories = &$arLighthouse['categories'];
		$arAudits = &$arLighthouse['audits'];
		
		# Prepare audits
		foreach($arCategories as $strCategory => &$arCategory){
			$intScore = is_numeric($arCategory['score']) ? $arCategory['score'] * 100 : null;
			$arResult['audits'][$strCategory] = [
				'title' => $arCategory['title'],
				'score' => $intScore,
				'title_score' => $arCategory['title'].(is_numeric($intScore) ? ' ('.$intScore.')' : ''),
				'items' => [],
			];
			$arCategoryAudits = [];
			foreach($arCategory['auditRefs'] as &$arAuditRef){
				$strGroup = strlen($arAuditRef['group']) ? $arAuditRef['group'] : static::AUDITS_GROUP_DEFAULT;
				$arGroup = &$arCategoryAudits[$strGroup];
				if(!is_array($arGroup)){
					$arGroup = [];
					if(is_array($arLighthouse['categoryGroups'][$strGroup])){
						$arGroup = $arLighthouse['categoryGroups'][$strGroup];
					}
					$arGroup = array_merge($arGroup, [
						'id' => $strGroup,
						'sort' => $strGroup == static::AUDITS_GROUP_DEFAULT ? 1000 : 100
					], static::getOutputGroups(false));
					foreach(['title', 'description'] as $strKey){
						if(isset($arGroup[$strKey])){
							$arGroup[$strKey] = static::prepareDescriptionText($arGroup[$strKey]);
						}
					}
				}
				$arAudit = array_merge($arAudits[$arAuditRef['id']], [
					'_category' => $strCategory,
					'_group' => $strGroup,
					'_weight' => $arAuditRef['weight'],
				]);
				foreach(['title', 'description'] as $strKey){
					if(isset($arAudit[$strKey])){
						$arAudit[$strKey] = static::prepareDescriptionText($arAudit[$strKey]);
					}
				}
				if(is_array($arAudit['details'])){
					ksort($arAudit['details']);
				}
				$strAuditType = static::getAuditType($arAudit);
				$arGroup[$strAuditType][] = $arAudit;
				# Unset empty subgroups
				foreach(static::getOutputGroups(false) as $strSubgroup => $arSubgroup){
					if(empty($arGroup[$strSubgroup])){
						unset($arGroup[$strSubgroup]);
					}
				}
				unset($arGroup);
			}
			unset($arAuditRef);
			$arResult['audits'][$strCategory]['items'] = $arCategoryAudits;
		}
		unset($arCategory);
		static::sortLighthouseGroups($arResult);
		
		# Prepare screenshots
		
		# Return
		return $arResult;
	}
	
	/**
	 *	Set sort values
	 */
	protected static function sortLighthouseGroups(&$arResult){
		# performance
		static::sortLighthouseItem($arResult, 'performance', 'load-opportunities', 1);
		static::sortLighthouseItem($arResult, 'performance', 'diagnostics', 2);
		static::sortLighthouseItem($arResult, 'performance', 'budgets', 3);
		static::sortLighthouseItem($arResult, 'performance', 'metrics', 4);
		# best-practices
		static::sortLighthouseItem($arResult, 'best-practices', 'best-practices-general', 1);
		static::sortLighthouseItem($arResult, 'best-practices', 'best-practices-trust-safety', 2);
		static::sortLighthouseItem($arResult, 'best-practices', 'best-practices-browser-compat', 3);
		static::sortLighthouseItem($arResult, 'best-practices', 'best-practices-ux', 4);
		# pwa
		static::sortLighthouseItem($arResult, 'pwa', 'pwa-fast-reliable', 1);
		static::sortLighthouseItem($arResult, 'pwa', 'pwa-optimized', 2);
		static::sortLighthouseItem($arResult, 'pwa', 'pwa-installable', 3);
		# seo
		static::sortLighthouseItem($arResult, 'seo', 'seo-crawl', 1);
		static::sortLighthouseItem($arResult, 'seo', 'seo-content', 2);
		static::sortLighthouseItem($arResult, 'seo', 'seo-mobile', 3);
		# 
		static::sortLighthouseItem($arResult, 'accessibility', 'a11y-best-practices', 1);
		#
		foreach($arResult['audits'] as $strCategory => &$arCategory){
			usort($arCategory['items'], function($a, $b){
				if($a['sort'] == $b['sort']) {
					return 0;
				}
				return ($a['sort'] < $b['sort']) ? -1 : 1;
			});
		}
		unset($arCategory);
	}
	
	/**
	 *	Set sort value
	 */
	protected static function sortLighthouseItem(&$arResult, $strCategory, $strGroup, $intValue){
		if(is_array($arResult['audits'][$strCategory]['items'][$strGroup])){
			$arResult['audits'][$strCategory]['items'][$strGroup]['sort'] = $intValue;
		}
		else{
			$arResult['audits'][$strCategory]['items'][$strGroup]['sort'] = '[!!!!]';
		}
	}
	
	/**
	 *	Get score threshold value
	 */
	public static function getFinishedScore(){
		return 90;
	}
	
	/**
	 *	Get audit status - actual or finished
	 */
	public static function getAuditType($arAudit){
		$strResult = static::AUDITS_INFO;
		if($arAudit['_category'] == 'performance' && in_array($arAudit['_group'], ['metrics', static::AUDITS_GROUP_DEFAULT])){
			$strResult = static::AUDITS_INFO;
		}
		elseif(is_numeric($arAudit['score'])){
			$intScore = $arAudit['score'] * 100;
			if($intScore <= static::getFinishedScore()){
				$strResult = static::AUDITS_ACTUAL;
			}
			else{
				$strResult = static::AUDITS_FINISHED;
			}
		}
		return $strResult;
	}
	
	/**
	 *	Get groups (actual, finished, info)
	 */
	public static function getOutputGroups($bFullinfo=false){
		$arResult = [
			static::AUDITS_ACTUAL => [],
			static::AUDITS_FINISHED => [],
			static::AUDITS_INFO => [],
		];
		if($bFullinfo){
			$arResult[static::AUDITS_FINISHED]['COLLAPSED'] = true;
			$arResult[static::AUDITS_INFO]['COLLAPSED'] = true;
		}
		return $arResult;
	}
	
}

