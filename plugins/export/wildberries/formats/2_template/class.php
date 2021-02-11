<?
/**
 * Acrit Core: Wildberries plugin
 */

namespace Acrit\Core\Export\Plugins;

use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main\EventManager,
	\Acrit\Core\Helper,
	\Acrit\Core\Export\Exporter,
	\Acrit\Core\Export\Field\Field,
	\Acrit\Core\Log,
	\Acrit\Core\Json,
	\Acrit\Core\Export\ExportDataTable as ExportData;

Loc::loadMessages(__FILE__);

class WildberriesTemplate extends Wildberries {
	
	CONST DATE_UPDATED = '2020-10-06';


	/**
	 * Base constructor
	 */
	public function __construct($strModuleId) {
		parent::__construct($strModuleId);
	}

	/* START OF BASE STATIC METHODS */

	/**
	 * Get plugin unique code ([A-Z_]+)
	 */
	public static function getCode() {
		return parent::getCode().'_TEMPLATE';
	}

	/**
	 * Get plugin short name
	 */
	public static function getName() {
		return static::getMessage('NAME');
	}

	/**
	 *	Is it subclass?
	 */
	public static function isSubclass(){
		return true;
	}

	/**
	 *	Are categories export?
	 */
	public function areCategoriesExport(){
		return true;
	}

	/* END OF BASE STATIC METHODS */

	/**
	 *	Show plugin default settings
	 */
	protected function showDefaultSettings(){
		ob_start();
		?>
		<table class="acrit-exp-plugin-settings" style="width:100%;">
			<tbody>
			<tr>
				<td width="40%" class="adm-detail-content-cell-l">
					<?=Helper::ShowHint(static::getMessage('SETTINGS_TOKEN_HINT'));?>
					<?=static::getMessage('SETTINGS_TOKEN');?>:
				</td>
				<td width="60%" class="adm-detail-content-cell-r">
					<input type="text" name="PROFILE[PARAMS][TOKEN]" id="acrit_exp_plugin_wildberries_token" value="<?=$this->arProfile['PARAMS']['TOKEN'];?>" size="90" />
				</td>
			</tr>
			<?
			try {
				$arTList = $this->getWBTemplates();
			}
			catch (\Exception $e) {
				$error_msg = $e->getMessage();
			}
			?>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l">
					<?=Helper::ShowHint(static::getMessage('SETTINGS_TEMPLATE_ID_HINT'));?>
					<?=static::getMessage('SETTINGS_TEMPLATE_ID');?>:
                </td>
                <td width="60%" class="adm-detail-content-cell-r">
                    <select name="PROFILE[PARAMS][TEMPLATE_ID]">
						<?foreach ($arTList as $id => $name):?>
                        <option value="<?=$id;?>"<?=$this->arProfile['PARAMS']['TEMPLATE_ID']==$id?' selected':''?>><?=$name;?></option>
						<?endforeach;?>
                    </select>
					<?= $error_msg ? ('<p><span class="required">' . $error_msg . '</span></p>') : ''; ?>
                </td>
            </tr>
			<?
			try {
				$arSList = $this->getWBSpecs();
			}
			catch (\Exception $e) {
				$error_msg = $e->getMessage();
			}
			?>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l">
					<?=Helper::ShowHint(static::getMessage('SETTINGS_SPEC_ID_HINT'));?>
					<?=static::getMessage('SETTINGS_SPEC_ID');?>:
                </td>
                <td width="60%" class="adm-detail-content-cell-r">
                    <select name="PROFILE[PARAMS][SPEC_ID]">
						<?foreach ($arSList as $id => $name):?>
                        <option value="<?=$id;?>"<?=$this->arProfile['PARAMS']['SPEC_ID']==$id?' selected':''?>><?=$name;?></option>
						<?endforeach;?>
                    </select>
					<?= $error_msg ? ('<p><span class="required">' . $error_msg . '</span></p>') : ''; ?>
                </td>
            </tr>
			<?if ($this->arProfile['PARAMS']['TEMPLATE_ID']):?>
				<?
				try {
					$arFList = $this->getWBIDFields($this->arProfile['PARAMS']['TEMPLATE_ID']);
				}
				catch (\Exception $e) {
					$error_msg = $e->getMessage();
				}
				?>
				<tr>
					<td width="40%" class="adm-detail-content-cell-l">
						<?=Helper::ShowHint(static::getMessage('SETTINGS_WB_ID_HINT'));?>
						<?=static::getMessage('SETTINGS_WB_ID');?>:
					</td>
					<td width="60%" class="adm-detail-content-cell-r">
						<select name="PROFILE[PARAMS][WB_ID]">
							<?foreach ($arFList as $id => $name):?>
                            <option value="<?=$id;?>"<?=$this->arProfile['PARAMS']['WB_ID']==$id?' selected':''?>><?=$name;?></option>
							<?endforeach;?>
						</select>
						<?= $error_msg ? ('<p><span class="required">' . $error_msg . '</span></p>') : ''; ?>
					</td>
				</tr>
				<tr>
					<td width="40%" class="adm-detail-content-cell-l">
						<?=Helper::ShowHint(static::getMessage('SETTINGS_WB_DICT_LOAD_HINT'));?>
						<?=static::getMessage('SETTINGS_WB_DICT_LOAD');?>:
					</td>
					<td width="60%" class="adm-detail-content-cell-r">
						<input type="checkbox" name="PROFILE[PARAMS][WB_DICT_LOAD]" <?=$this->arProfile['PARAMS']['WB_DICT_LOAD']=='Y'?' checked':''?> value="Y" />
					</td>
				</tr>
			<?endif;?>
			</tbody>
		</table>
		<?
		return ob_get_clean();
	}

	/**
	 *	Get available fields for current plugin
	 */
	public function getFields($intProfileID, $intIBlockID, $bAdmin=false){
		global $DB;
		$DB->Query("SET wait_timeout=28800");

		$arResult = parent::getFields($intProfileID, $intIBlockID, $bAdmin);

		$intTemplateId = $this->arProfile['PARAMS']['TEMPLATE_ID'];
		$intSpecId = $this->arProfile['PARAMS']['SPEC_ID'];
		try {
		    if ($intSpecId) {
			    $arOrderRes = $this->request('specdata/' . $intSpecId);
		    }
		    else {
			    $arOrderRes = $this->request('new-by-template/' . $intTemplateId);
		    }
		}
		catch (\Exception $e) {
//			echo $e->getMessage();
		}
		$arFList = $arOrderRes['Data']['Fields'];

		if (!empty($arFList)) {
			$i = 0;
			foreach ($arFList as $arItem) {
				$arDefault = array();
				$arParams = array();
				$arField = array(
					'CODE' => $arItem['Id'],
					'DISPLAY_CODE' => $arItem['Id'],
					'NAME' => $arItem['Name'],
					'SORT' => $i,
					'DESCRIPTION' => '',
//					'MULTIPLE' => $arItem['isMultiple'],
				);
//				if ($arItem['IsRequired']) {
//					$arField['REQUIRED'] = true;
//				}
				if ($this->arProfile['PARAMS']['WB_DICT_LOAD'] == 'Y') {
					$arValues = $this->getWbDictionary($arItem['Id']);
					if ( ! empty($arValues)) {
						$arField['ALLOWED_VALUES']       = $arValues;
						$arField['POPUP_ALLOWED_VALUES'] = true;
					}
				}
				if (!empty($arDefault)) {
					$arField['DEFAULT_VALUE'] = $arDefault;
				}
				if (!empty($arParams)) {
					$arField['PARAMS'] = $arParams;
				}
				$arResult[] = new Field($arField);
				$i++;
			}
		}

		#
		$this->sortFields($arResult);
		return $arResult;
	}

	/**
	 *	Process single element
	 *	@return array
	 */
	public function processElement($arProfile, $intIBlockID, $arElement, $arFields){
		$intProfileID = $arProfile['ID'];
		$intElementID = $arElement['ID'];

		# Build exported data
		$arApiFields = [];
//		Log::getInstance($this->strModuleId)->add('(processElement) $arProfile: ' . print_r($arProfile, true), $intProfileID);
//		Log::getInstance($this->strModuleId)->add('(processElement) $arFields: ' . print_r($arFields, true), $intProfileID);
		foreach ($arFields as $code => $arItem) {
//			if (!Helper::isEmpty($arFields[$code])) {
				$arApiFields[$code] = Json::addValue($arFields[$code]);
//			}
		}
//		Log::getInstance($this->strModuleId)->add('(processElement) $arApiFields: ' . print_r($arApiFields, true), $intProfileID);
		# build JSON
		foreach (EventManager::getInstance()->findEventHandlers($this->strModuleId, 'OnWildberriesGoodsJson') as $arHandler) {
			ExecuteModuleEventEx($arHandler, array(&$arApiFields, $arProfile, $intIBlockID, $arElement, $arFields));
		}
		# build result
		$arResult = array(
			'TYPE' => 'JSON',
			'DATA' => Json::encode($arApiFields),
			'CURRENCY' => '',
			'SECTION_ID' => $this->getElement_SectionID($intProfileID, $arElement),
			'ADDITIONAL_SECTIONS_ID' => Helper::getElementAdditionalSections($intElementID, $arElement['IBLOCK_SECTION_ID']),
			'DATA_MORE' => array(),
		);
		foreach (EventManager::getInstance()->findEventHandlers($this->strModuleId, 'OnWildberriesGoodsResult') as $arHandler) {
			ExecuteModuleEventEx($arHandler, array(&$arResult, $arApiFields, $arProfile, $intIBlockID, $arElement, $arFields));
		}
		# after..
		unset($intProfileID, $intElementID, $arApiFields);
		return $arResult;
	}


	/**
	 *	Get steps
	 */
	public function getSteps(){
		$arResult = array();
		$arResult['EXPORT'] = array(
			'NAME' => static::getMessage('STEP_EXPORT'),
			'SORT' => 100,
			'FUNC' => array($this, 'stepExport'),
		);
		return $arResult;
	}

	/**
	 *	Step: Export
	 */
	public function stepExport($intProfileID, $arData){
		$arSession = &$arData['SESSION']['EXPORT'];
		$bIsCron = $arData['IS_CRON'];

		$intWbTemplateId = $this->arProfile['PARAMS']['TEMPLATE_ID'];
		$intWbIdField = $this->arProfile['PARAMS']['WB_ID'];
		$intWbSpecId = $this->arProfile['PARAMS']['SPEC_ID'];
		try {
			if ($intWbSpecId) {
				$arSpecRes = $this->request('specdata/' . $intWbSpecId);
			}
			else {
				$arSpecRes = $this->request('new-by-template/' . $intWbTemplateId);
			}
		}
		catch (\Exception $e) {
//			echo $e->getMessage();
		}
		$arSpecData = $arSpecRes['Data']['Data'];

		if (!$intWbIdField) {
			Log::getInstance($this->strModuleId)->add('Empty Wildberries item identifier', $intProfileID);
			return;
		}

		// Get export data
		$arQuery = [
			'PROFILE_ID' => $intProfileID,
			'!TYPE' => ExportData::TYPE_DUMMY,
		];
		$intExportCount = Helper::call($this->strModuleId, 'ExportData', 'getCount', [$arQuery]);
		$intOffset = 0;
		$intIndex = 0;
		while ($intIndex < $intExportCount) {
			$intLimit = 1000;
			$strSortOrder = ToUpper($arData['PROFILE']['PARAMS']['SORT_ORDER']);
			if (!in_array($strSortOrder, array('ASC', 'DESC'))) {
				$strSortOrder = 'ASC';
			}
			$arQuery = [
				'filter' => [
					'PROFILE_ID' => $intProfileID,
					'!TYPE' => ExportData::TYPE_DUMMY,
				],
				'order'  => [
					'SORT' => $strSortOrder,
				],
				'select' => [
					'IBLOCK_ID',
					'ELEMENT_ID',
					'SECTION_ID',
					'TYPE',
					'DATA',
				],
				'limit' => $intLimit,
				'offset' => $intOffset * $intLimit,
			];
			$resItems = Helper::call($this->strModuleId, 'ExportData', 'getList', [$arQuery]);
			$intExportedCount = 0;
			$arWbFindedItems = [];
			// Export item
			while ($arItem = $resItems->fetch()) {
				$arItemData = Json::decode($arItem['DATA']);
//				Log::getInstance($this->strModuleId)->add('$arItemData: ' . print_r($arItemData, true), $intProfileID);

				// Find WB item for this IB item
				$intWbItemIndex = false;
				foreach ($arSpecData as $r => $arRow) {
					foreach ($arRow as $arField) {
						if ($arField['FieldId'] == $intWbIdField && $arField['Value'] && $arItemData[$arField['FieldId']]
						    && $arField['Value'] == $arItemData[$arField['FieldId']]) {
							$intWbItemIndex = $r;
							$arWbFindedItems[] = $intWbItemIndex;
						}
					}
					if ($intWbItemIndex) {
						break;
					}
				}
//				Log::getInstance($this->strModuleId)->add('$intWbItemRowIndex ' . $intWbItemIndex, $intProfileID);
				// Update WB data item
				if ($intWbItemIndex !== false) {
					foreach ($arItemData as $id => $value) {
						foreach ($arSpecData[$intWbItemIndex] as $k => $arField) {
							if ($id == $arField['FieldId']) {
								$arSpecData[$intWbItemIndex][$k]['Value'] = $value;
							}
						}
					}
					// Not found in the catalog
					foreach ($arSpecData as $r => $arRow) {
						if (!in_array($r, $arWbFindedItems)) {
							$strProductName = '';
							foreach ($arRow as $arField) {
								if ($arField['FieldId'] == $intWbIdField) {
									$strProductName = $arField['Value'];
								}
							}
							Log::getInstance($this->strModuleId)->add(static::getMessage('PROCESS_NOT_FOUND') . $strProductName, $intProfileID);
						}
					}
				}
				// Add WB data item
				else {
					$intWbItemIndex = count($arSpecData);
					foreach ($arItemData as $id => $value) {
						if (strlen((string)$value) > 0) {
							$arSpecData[$intWbItemIndex][] = [
								'FieldId' => $id,
								'Value' => $value,
							];
						}
					}
				}

				$intIndex++;
			}

			// Count result
			$arData['SESSION']['EXPORT']['INDEX'] += $intExportedCount;
			$intOffset++;
		}

		// Send specifications data
		$this->stepExport_send($intProfileID, $arSpecData, $intWbTemplateId);

		return Exporter::RESULT_SUCCESS;
	}

	// Send specification for check
	private function stepExport_send($intProfileID, $arData, $intWbTemplateId) {
		$arSpecData = [
			'Template' => [
				'Id' => $intWbTemplateId,
			],
			'Data' => $arData,
		];
		$intWbSpecId = $this->arProfile['PARAMS']['SPEC_ID'];
		if ($intWbSpecId) {
			$arSpecData['Uid'] = $intWbSpecId;
		}
//		Log::getInstance($this->strModuleId)->add('load data: ' . print_r($arSpecData, true), $intProfileID);
		try {
			$arResp = $this->request('load-by-template', [], 'post', \Bitrix\Main\Web\Json::encode($arSpecData));
		}
		catch (\Exception $e) {
			Log::getInstance($this->strModuleId)->add(static::getMessage('PROCESS_LOAD_RESPONSE') . $e->getMessage() . ' [' . $e->getCode() . ']', $intProfileID);
		}
		if ($arResp) {
			if ($arResp['ResultCode']) {
				Log::getInstance($this->strModuleId)->add(static::getMessage('PROCESS_LOAD_RESPONSE') . $arResp['Message'] . ' [' . $arResp['ResultCode'] . ']', $intProfileID);
			} else {
				Log::getInstance($this->strModuleId)->add(static::getMessage('PROCESS_LOAD_RESPONSE') . 'Success', $intProfileID);
			}
			if ($arResp['Data']['Errors']) {
//			Log::getInstance($this->strModuleId)->add('resp data '.print_r($arResp['Data']['Data'], 1), $intProfileID);
				$this->stepExport_displayErrors($intProfileID, $arResp);
			}
		}
	}

	private function stepExport_displayErrors($intProfileID, $arResp) {
		$intWbIdField = $this->arProfile['PARAMS']['WB_ID'];
		foreach ($arResp['Data']['Data'] as $r => $arRow) {
			$strFieldName = '';
			$arErrorGroups = [];
			foreach ($arRow as $arItem) {
				// Product identifier name
				if ($arItem['FieldId'] == $intWbIdField) {
					$strFieldName = $arItem['Value'];
				}
				// Errors
				if ($arItem['ErrorId']) {
					// Error title
					$title = '';
					$err_group_i = false;
					foreach ($arResp['Data']['Errors'] as $err_i => $arErGroup) {
						foreach ($arErGroup['Ids'] as $intErId) {
							if ($intErId == $arItem['ErrorId']) {
								$title = $arErGroup['Msg'];
								$err_group_i = $err_i;
							}
						}
					}
					if ($err_group_i !== false) {
						$arErrorGroups[$err_group_i]['title'] = $title;
						// Error fields
						$title = '';
						foreach ($arResp['Data']['Fields'] as $arField) {
							if ($arField['Id'] == $arItem['FieldId']) {
								$title = $arField['Name'];
							}
						}
						$arErrorGroups[$err_group_i]['items'][] = $title ? $title : $arItem['FieldId'];
					}
				}
			}
			foreach ($arErrorGroups as $arItem) {
				$arErrors = $arItem['items'];
				Log::getInstance($this->strModuleId)->add($strFieldName.' - '.$arItem['title'].': ' . implode(", ", $arErrors), $intProfileID);
			}
		}
	}


	/**
	 * Ajax actions
	 */

	public function ajaxAction($strAction, $arParams, &$arJsonResult) {
		parent::ajaxAction($strAction, $arParams, $arJsonResult);
		#$arProfile = Profile::getProfiles($arParams['PROFILE_ID']);
		$strVkGroupId = strval($this->arProfile['PARAMS']['GROUP_ID']);
		$strVkOwnerId = intval('-' . $strVkGroupId);
		switch ($strAction) {
		}
	}

	/**
	 * Get Wildberries field dictionary
	 */
	protected function getWbDictionary($strFieldId) {
		$arList = false;
		try {
			$arResp = $this->request('dictionary/' . $strFieldId);
		}
		catch (\Exception $e) {
//			echo $e->getMessage();
		}
		if (!$arResp['ResultCode']) {
			$arList = [];
			foreach ($arResp['Data'] as $value) {
				$arList[$value] = $value;
			}
		}
		return $arList;
	}

	/**
	 *	Get WB fields for identification
	 */

	public function getWBTemplates() {
		$arList = [];
			$arRes = $this->request('template/dictionary');
			foreach ($arRes['Data'] as $arItem) {
				$arList[$arItem['id']] = $arItem['name'].' ('.$arItem['id'].')';
			}
		return $arList;
	}

	/**
	 *	Get WB fields for identification
	 */

	public function getWBSpecs() {
		$arList = [];
		$arRes = $this->request('speclist');
		$arList[] = static::getMessage('SETTINGS_SPEC_ID_NEW');
		foreach ($arRes['Data'] as $arItem) {
			$arList[$arItem['specification_uid']] = $arItem['descr'].' ('.$arItem['specification_uid'].', '.$arItem['dt'].')';
		}
		return $arList;
	}

	/**
	 *	Get WB fields for identification
	 */

	public function getWBIDFields($intTemplateId) {
		$arList = [];
		if ($intTemplateId) {
			$arOrderRes = $this->request('new-by-template/' . $intTemplateId);
			foreach ($arOrderRes['Data']['Fields'] as $arItem) {
				$arList[$arItem['Id']] = $arItem['Name'].' ('.$arItem['Id'].')';
			}
		}
		return $arList;
	}

}

?>