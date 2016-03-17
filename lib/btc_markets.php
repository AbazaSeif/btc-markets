<?php
namespace btcMarkets;

use \btcMarkets\marketData;
use \Exception as Exception;

class btcMarkets {
	
	protected $_apiBase = 'https://api.btcmarkets.net';

	/**
	* Get the latest ticker information from the API
	*
	* @param string $cryptoCoin 
	*/
	public function getTick( $cryptoCoin='BTC' ) 
	{
		$requestUrl = '/market/' . $cryptoCoin . '/AUD/tick';

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 
	
	/**
	* Get the latest trade information from the API
	*
	* @param string $cryptoCoin 
	*/
	public function getTrades( $cryptoCoin='BTC' ) 
	{
		$requestUrl = '/market/' . $cryptoCoin . '/AUD/trades';

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 

	/**
	* Get the order book from the API
	*
	* @param string $cryptoCoin 
	*/
	public function getOrderBook( $cryptoCoin = 'BTC' ) 
	{
		$requestUrl = '/market/' . $cryptoCoin . '/AUD/orderbook';

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 	
	
	/**
	* Convert a JSON response into an object
	*
	* @param string $jsonStr
	*
	* @return object 
	*/
	public function parseJson( $jsonStr )
	{
		$jsonObj = json_decode( $jsonStr );

		if (json_last_error()) {
			throw new Exception('Invalid JSON response');
		}

		return $jsonObj;
	}

	/**
	* Request data from the BTCmarkets.net API
	*
	* @param string $requestUrl
	* @param array $requestParams
	*
	* @return object
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