<?php
namespace btcMarkets;

use \btcMarkets\marketData;
use \Exception as Exception;

class bitFinex extends marketAPI {
	
	protected $_apiBase = 'https://api.bitfinex.com/v1';

	/**
	* Get the latest ticker information from the API - More details can be found at http://docs.bitfinex.com/#ticker
	*
	* @param string $cryptoCoin 
	*
	* @return array $apiResp 	
	*/
	public function getTick( $cryptoCoin='BTC' ) 
	{
		$requestUrl = '/pubticker/' . $cryptoCoin;

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 

	/**
	* Get the stats for a currency - More details can be found at http://docs.bitfinex.com/#stats
	*
	* @param string $cryptoCoin 
	*
	* @return array $apiResp 	
	*/
	public function getStats( $cryptoCoin='BTC' ) 
	{
		$requestUrl = '/stats/' . $cryptoCoin;

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	}

	/**
	* Recent funcding data for a currency- More details can be found at http://docs.bitfinex.com/#lends
	*
	* @param string $cryptoCoin 
	*
	* @return array $apiResp 	
	*/
	public function getStats( $cryptoCoin='BTC' ) 
	{
		$requestUrl = '/lends/' . $cryptoCoin;

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	}
}