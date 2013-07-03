<?php
/*
	CartoDB Proxy Private Class
	This class should not be modified and all overrides should be modified in the public functions.
*/
class _CartoProxy {

	var $cdbAccount, $cdbKey;
	var $tileRequestTemplate = "http://%s.cartodb.com/tiles/%s?sql=%s";
	var $sqlRequestTemplate = "http://%s.cartodb.com/api/v2/sql?";
	
	function __construct($dataConfig) {
		$this->cdbAccount = $dataConfig['account'];
		$this->cdbKey = $dataConfig['cdbKey'];
		$this->ext = '';
		$this->contentType = '';
		$this->tileString = $dataConfig['tileString'];
		$this->sqlString = $dataConfig['sql'];
		$this->allowSQL = true;
		$this->allowTiles = true;
		$this->allowWax = true;
		$this->ignoreTable = array();
		if($dataConfig['tileString'] != '') {
			if (strrpos($this->tileString, '.')) {
				$this->ext = strtolower(substr($this->tileString, (strrpos($this->tileString, '.') ? strrpos($this->tileString, '.') + 1 : strlen($this->tileString)), strlen($this->tileString)));
				$this->contentType = 'image/' . ($this->ext == 'jpg' ? 'jpeg' : $this->ext);
			}
		}
	}
	
	private function request($url) {
		$this->lastRequest = $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);     
		if ($response_code == "400") {
			$this->lastError = json_decode($response, true);
			return(false);
		} else {
			return($response);
		}
	}
	
	public function authenticate() {
		return true;
	}
	
	public function getTiles() {
		$url = sprintf($this->tileRequestTemplate, $this->cdbAccount, $this->tileString, $this->sqlString) . '&api_key=' . $this->cdbKey;
		// echo $url;
		// echo $this->contentType;
		// echo file_get_contents($url);
		header("content-type: " . $this->contentType);
		echo $this->request($url);
	}

}
?>