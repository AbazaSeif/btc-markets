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
	* @param string $priceUnit 	
	*
	* @return array $apiResp 	
	*/
	public function getTick( $cryptoCoin='BTC', $priceUnit='AUD' ) 
	{
		$requestUrl = '/market/' . $cryptoCoin . '/' . $priceUnit . '/tick';

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 
	
	/**
	* Get the latest trade information from the API
	*
	* @param string $cryptoCoin
	* @param string $priceUnit 	
	*
	* @return array $apiResp 
	*/
	public function getTrades( $cryptoCoin='BTC', $priceUnit='AUD' ) 
	{
		$requestUrl = '/market/' . $cryptoCoin . '/' . $priceUnit . '/trades';

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 

	/**
	* Get the order book from the API
	*
	* @param string $cryptoCoin 
	* @param string $priceUnit 	
	*
	* @return array $apiResp 	
	*/
	public function getOrderBook( $cryptoCoin = 'BTC', $priceUnit='AUD' ) 
	{
		$requestUrl = '/market/' . $cryptoCoin . '/' . $priceUnit . '/orderbook';

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 	
}