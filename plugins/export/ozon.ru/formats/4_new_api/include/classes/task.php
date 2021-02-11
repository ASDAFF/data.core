<?
/**
 * Data Core: ozon.ru tasks
 * @documentation https://docs.ozon.ru/api/seller
 */

namespace Data\Core\Export\Plugins\OzonRuHelpers;

use
	\Data\Core\Helper,
	\Bitrix\Main\Entity;

Helper::loadMessages(__FILE__);

class TaskTable extends Entity\DataManager {
	
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName(){
		return 'data_ozon_task';
	}
	
	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap() {
		\Data\Core\Export\Exporter::getLangPrefix(realpath(__DIR__.'/../../../class.php'), $strLang, $strHead, 
			$strName, $strHint);
		return array(
			'ID' => new Entity\IntegerField('ID', array(
				'primary' => true,
				'autocomplete' => true,
				'title' => Helper::getMessage($strLang.'ID'),
			)),
			'PROFILE_ID' => new Entity\IntegerField('PROFILE_ID', array(
				'title' => Helper::getMessage($strLang.'PROFILE_ID'),
			)),
			'TASK_ID' => new Entity\IntegerField('TASK_ID', array(
				'title' => Helper::getMessage($strLang.'TASK_ID'),
			)),
			'PRODUCTS_COUNT' => new Entity\IntegerField('PRODUCTS_COUNT', array(
				'title' => Helper::getMessage($strLang.'PRODUCTS_COUNT'),
			)),
			'JSON' => new Entity\StringField('JSON', array(
				'title' => Helper::getMessage($strLang.'JSON'),
			)),
			'STATUS' => new Entity\StringField('STATUS', array(
				'title' => Helper::getMessage($strLang.'STATUS'),
			)),
			'STATUS_DATETIME' => new Entity\DatetimeField('STATUS_DATETIME', array(
				'title' => Helper::getMessage($strLang.'STATUS_DATETIME'),
			)),
			'SESSION_ID' => new Entity\StringField('SESSION_ID', array(
				'title' => Helper::getMessage($strLang.'SESSION_ID'),
			)),
			'TIMESTAMP_X' => new Entity\DatetimeField('TIMESTAMP_X', array(
				'title' => Helper::getMessage($strLang.'TIMESTAMP_X'),
			)),
		);
	}
	
	/**
	 * Delete by filter
	 *
	 * @return array
	 */
	public static function deleteByFilter($arFilter=null) {
		$strTable = static::getTableName();
		$strSql = "DELETE FROM `{$strTable}` WHERE 1=1";
		if(is_array($arFilter)){
			foreach($arFilter as $strField => $strValue){
				$strEqual = '=';
				if(preg_match('#^(.*?)([A-z0-9_]+)(.*?)$#', $strField, $arMatch)){
					$strField = $arMatch[2];
					if($arMatch[1] == '!'){
						$strEqual = '!=';
					}
				}
				$strField = \Bitrix\Main\Application::getConnection()->getSqlHelper()->forSql($strField);
				$strValue = \Bitrix\Main\Application::getConnection()->getSqlHelper()->forSql($strValue);
				if(is_numeric($strField)){
					$strSql .= " AND ({$strValue})";
				}
				else{
					$strSql .= " AND (`{$strField}`{$strEqual}'{$strValue}')";
				}
			}
			$strSql .= ';';
		}
		return \Bitrix\Main\Application::getConnection()->query($strSql);
	}

}
