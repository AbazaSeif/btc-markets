<?php 

namespace btcmarkets;

class marketAPI {
	/**
	* Request data from the BTCmarkets.net API
	*
	* @param string $requestUrl
	* @param array $requestParams
	*
	* @return object $apiResp
	*/
	protected function _apiRequest( $requestUrl ) 
	{
		$curlHandle = curl_init();

		curl_setopt_array($curlHandle, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $this->_apiBase . $requestUrl,
		));

		$apiResp = curl_exec($curlHandle);
		curl_close($curlHandle);

		return $apiResp;
	}
}