<?php
class RESTClient extends DataObject {
	public static $db = array(
		"Base" => "Text"
	);

	public $Base;

	protected $curl;
	
	public function request($subURL = '', $curlOpts = array()) {
		assert(is_string($subURL));
		assert(is_array($curlOpts));
		
		if(!$this->curl) $this->curlInit();
		
		$curl = curl_copy_handle($this->curl);
		curl_setopt($curl, CURLOPT_URL, http_build_url(
				curl_getinfo($curl, CURLINFO_EFFECTIVE_URL),
				$subURL,
				HTTP_URL_JOIN_PATH | HTTP_URL_JOIN_QUERY
			)
		);
		
		curl_setopt_array($curl, $curlOpts);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		return curl_exec($curl);
	}
	
	protected function curlInit() {
		assert(is_string($this->Base));
		
		$this->curl = curl_init($this->Base);
	}
}
