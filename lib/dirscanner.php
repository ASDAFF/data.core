<?php
namespace Acrit\Core;

use
	\Acrit\Core\Helper;

class DirScanner {
	
	const RESULT_CONTINUE = 'CONTINUE';
	
	protected $fStartTime = null;
	protected $fStepTime = 3; // default is 3 seconds
	
	protected $arSkip = [];
	protected $arExt = [];
	
	protected $mCallbackFile = null;
	protected $mCallbackDirBefore = null;
	protected $mCallbackDirAfter = null;
	protected $mCallbackSkip = null;
	protected $mCallbackHaveTime = null;
	
	protected $intDirCount = 0;
	protected $intFileCount = 0;
	protected $strNextPath = '';
	protected $strStartPath = '';
	protected $arErrors = [];
	
	/**
	 *	Wrapper for $this->scan(), start process
	 */
	public function start($strDir=null){
		$this->fStartTime = microtime(true);
		if(!is_string($strDir) || !strlen($strDir)){
			$strDir = Helper::root();
		}
		return $this->scan($strDir);
	}
	
	/**
	 *	Set step time
	 */
	public function setStepTime($fStepTime){
		$this->fStepTime = floatVal($fStepTime);
	}
	
	/**
	 *	Set used file extensions (without dots)
	 */
	public function setExtensions(array $arExt){
		$this->arExt = $arExt;
		$this->arExt = array_map(function($item){
			return toUpper($item);
		}, $this->arExt);
	}
	
	/**
	 *	Set skip array (each item is a relative filename)
	 */
	public function setSkip(array $arSkip, $bAddDocumentRoot=true){
		$this->arSkip = $arSkip;
		if($bAddDocumentRoot){
			$this->arSkip = array_map(function($strItem){
				return Helper::root().$strItem;
			}, $this->arSkip);
		}
		$this->arSkip = array_map(function($item){
			return rtrim(Helper::path($item), '\\/');
		}, $this->arSkip);
		$this->arSkip = array_map(function($item){
			return true;
		}, array_flip($this->arSkip));
	}
	
	/**
	 *	Set callbacks
	 */
	public function setCallbackFile(callable $mCallback){
		$this->mCallbackFile = $mCallback;
	}
	public function setCallbackDirBefore(callable $mCallback){
		$this->mCallbackDirBefore = $mCallback;
	}
	public function setCallbackDirAfter(callable $mCallback){
		$this->mCallbackDirAfter = $mCallback;
	}
	public function setCallbackSkip(callable $mCallback){
		$this->mCallbackSkip = $mCallback;
	}
	public function setCallbackHaveTime(callable $mCallback){
		$this->mCallbackHaveTime = $mCallback;
	}
	
	/**
	 *	Callback to process current file
	 *	return static::RESULT_CONTINUE to make one more step
	 *	return true to success current item
	 *	return false to error
	 */
	public function processFile($strFile) {
		if($this->haveTime()) {
			$strExt = toUpper(pathinfo($strFile, PATHINFO_EXTENSION));
			$bExtensionChecked = !is_array($this->arExt) || empty($this->arExt) || in_array($strExt, $this->arExt);
			if($bExtensionChecked && is_callable($this->mCallbackFile)){
				return call_user_func_array($this->mCallbackFile, [$this, $strFile]);
			}
			return true;
		}
		return static::RESULT_CONTINUE;
	}
	
	/**
	 *	Callback for processDirBefore
	 */
	public function processDirBefore($strDir) {
		if(is_callable($this->mCallbackDirBefore)){
			return call_user_func_array($this->mCallbackDirBefore, [$this, $strDir]);
		}
	}
	
	/**
	 *	Callback for processDirAfter
	 */
	public function processDirAfter($strDir) {
		if(is_callable($this->mCallbackDirAfter)){
			return call_user_func_array($this->mCallbackDirAfter, [$this, $strDir]);
		}
	}
	
	/**
	 *	Check current file must be skipped
	 */
	public function skip($strFile) {
		$bSkip = false;
		if($this->mCallbackSkip){
			return call_user_func_array($this->mCallbackSkip, [$this, $strFile]);
		}
		else{
			if($this->strStartPath) {
				if(Helper::strpos($this->strStartPath.'/', $strFile.'/') === 0) {
					if($this->strStartPath == $strFile) {
						unset($this->strStartPath);
					}
					return false;
				}
				else {
					return true;
				}
			}
			elseif($this->arSkip[$strFile]) {
				return true;
			}
		}
		return $bSkip;
	}
	
	/**
	 *	Check we are have time to continue this step, else - break
	 */
	public function haveTime(){
		if($this->mCallbackHaveTime){
			return call_user_func_array($this->mCallbackHaveTime, [$this]);
		}
		return microtime(true) - $this->fStartTime < $this->fStepTime;
	}
	
	protected function Scan($dir){
		$dir = Helper::path($dir);
		if($this->skip($dir)) {
			return;
		}
		$this->strNextPath = $dir;
		if(is_dir($dir)) { // It's a dir
			if(!$this->strStartPath) { // start path not found or not specified
				$result = $this->processDirBefore($dir);
				if($result === false){
					return false;
				}
			}
			if(!($handle = opendir($dir))) {
				$this->arErrors[] = sprintf('Error opening dir: %s.', $dir);
				return false;
			}
			while(($item = readdir($handle)) !== false) {
				if($item == '.' || $item == '..' || false !== Helper::strpos($item, '\\')){
					continue;
				}
				$result = $this->scan($dir."/".$item);
				if($result === false || $result === static::RESULT_CONTINUE) {
					closedir($handle);
					return $result;
				}
			}
			closedir($handle);
			if(!$this->strStartPath) { // start path not found or not specified
				if($this->processDirAfter($dir) === false)
					return false;
				$this->intDirCount++;
			}
		}
		else { // It's a file
			$result = $this->processFile($dir);
			if($result === false) {
				return false;
			}
			elseif($result === static::RESULT_CONTINUE){
				return $result;
			}
			$this->intFileCount++;
		}
		return true;
	}
	
	/**
	 *	Set start filename
	 */
	public function setStartPath($strStartPath){
		$this->strStartPath = $strStartPath;
	}
	
	/**
	 *	Ge next filename
	 */
	public function getNextPath(){
		return $this->strNextPath;
	}
	
	/**
	 *	Get processed files count
	 */
	public function getFileCount(){
		return $this->intFileCount;
	}
	
	/**
	 *	Get processed dir count
	 */
	public function getDirCount(){
		return $this->intDirCount;
	}
	
	/**
	 *	Get errors
	 */
	public function getErrors(){
		return $this->arErrors;
	}
	
}
