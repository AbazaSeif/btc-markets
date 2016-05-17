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

	/**
	* Convert a JSON response into an object
	*
	* @param string $jsonStr
	*
	* @return object $jsonResp
	*/
	public function parseJson( $jsonStr )
	{
		$jsonObj = json_decode( $jsonStr );

		if (json_last_error()) {
			throw new Exception('Invalid JSON response');
		}

		return $jsonObj;
	}	
}