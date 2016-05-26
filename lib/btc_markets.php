<?php
namespace btcMarkets;

use \btcMarkets\marketData;
use \Exception as Exception;

class btcMarkets extends marketAPI {
	
	protected $_apiBase = 'https://api.btcmarkets.net';
	protected $_selectedCurrency = 'AUD';

	/**
	* Return the currently selected currency
	*
	* @return string
	*/
	public function getCurrency()
	{
		return $this->_selectedCurrency;
	}

	/**
	* Set the selected currency currency
	*
	* @param string
	*
	* @return boolean
	*/
	public function setCurrency($selectedCurrency)
	{
		if ( ($selectedCurrency == 'AUD') || ($selectedCurrency == 'AUD') ) {
			$this->_selectedCurrency = $selectedCurrency;

			return true;
		} else {
			return false;
		}
	}

	/**
	* Get the latest ticker information from the API
	*
	* @param string $cryptoCoin 
	*
	* @return array $apiResp 	
	*/
	public function getTick( $cryptoCoin='BTC' ) 
	{
		$requestUrl = '/market/' . $cryptoCoin . '/' . $this->_selectedCurrency . '/tick';

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
		$requestUrl = '/market/' . $cryptoCoin . '/' . $this->_selectedCurrency . '/trades';

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
		$requestUrl = '/market/' . $cryptoCoin . '/' . $this->_selectedCurrency . '/orderbook';

		$apiResp = $this->_apiRequest( $requestUrl );

		return $apiResp;
	} 	
}