<?php
namespace btcMarkets;

use \btcMarkets\marketData;
use \Exception as Exception;

class btcMarkets extends marketAPI {
	
	protected $_apiBase = 'https://api.btcmarkets.net';

	/**
	* Get the latest ticker information from the API
	*
	* @param string $cryptoCoin 
	*
	* @return array $apiResp 	
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
	*
	* @return array $apiResp 
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
	*
	* @return array $apiResp 	
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