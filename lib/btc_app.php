<?php
namespace btcMarkets;

use \btcMarkets\marketData;
use \btcMarkets\btcMarkets;
use \btcMarkets\bitFinex;

class btcApp {
	protected $_activeCoins = array('BTC', 'LTC', 'ETH');
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
		if ( ($selectedCurrency == 'AUD') || ($selectedCurrency == 'USD') ) {
			$this->_selectedCurrency = $selectedCurrency;

			return true;
		} else {
			return false;
		}
	}

	/**
	*
	* Return an array of the active coins
	*
	* @return array $this->_activeCoins
	*/
	public function getActive()
	{
		return $this->_activeCoins;
	}

	/**
	*
	* Return an array of the active echanges in the database
	*
	* @return object
	*/
	public function getActiveExchanges()
	{
		$marketData = new marketData();
		$activeExchanges = $marketData->getActiveExchanges();

		return $activeExchanges;		
	}

	/**
	* Update the target ticker price for one currency
	*
	* @param string $targetUnit
	* @param string $priceUnit	
	*/
	public function updatePrice( $targetUnit = 'BTC' )
	{
		$btcMarkets = new btcMarkets();

		$apiResp = $btcMarkets->getTick( $targetUnit, $this->_selectedCurrency );

		$marketObj = $btcMarkets->parseJson( $apiResp );

		$marketData = new marketData();
		$tickerRow = $marketData->saveTicker( $marketObj, $this->_selectedCurrency );

		return $tickerRow;
	}

	/**
	* Get the latest ticker price for a currency
	*
	* @param string $targetUnit
	*/
	public function getPrice( $targetUnit = 'BTC' )
	{
		$marketData = new marketData();
		$tickerRow = $marketData->getPrice( $targetUnit, $this->_selectedCurrency );

		if ($tickerRow) {
			return $tickerRow;
		} else {
			return array('error' => 'Unable to retrieve any price data for this currency.', 'data' =>  null);
		}
	}

	/**
	* Get an object containing the latest trades from the exchange
	*
	* @return string
	*/
	public function latestTrades( $targetUnit='BTC' )
	{
		$btcMarkets = new btcMarkets();

		$apiResp = $btcMarkets->getTrades( $targetUnit, $this->_selectedCurrency );

		$marketData = new marketData();
		$tickerRow = $marketData->updateTrades( $apiResp, $targetUnit, $this->_selectedCurrency );

		return $btcMarkets->parseJson( $apiResp );	
	}

	/**
	* Get an object containing the exchange order book
	*
	* @return string
	*/
	public function orderBook( $targetUnit='BTC' )
	{
		$btcMarkets = new btcMarkets();

		$apiResp = $btcMarkets->getOrderBook( $targetUnit, $this->_selectedCurrency );

		return $btcMarkets->parseJson( $apiResp );	
	}

	/**
	* Get the average price 
	*
	* @param string $targetUnit
	* @param integer $timeFrame 
	*
	* @return array 
	*/
	public function averagePrice( $targetUnit='BTC', $timeFrame=NULL )
	{
		$marketData = new marketData();
		$timePeriod = $this->_convertTimeFrame( $timeFrame );
		$avgPrice = $marketData->averageTickerPrice( $targetUnit, $timePeriod, $this->_selectedCurrency );

		if ($avgPrice) {
			return array(
							'error' => null, 
							'data' =>  array( 'price' => $avgPrice, 'price_unit' => $this->_selectedCurrency )
						);			
		} else {
			return array('error' => 'Not enough data to provide average price.', 'data' =>  null);
		}
	}

	/**
	* Get a price summary for a currency over a given currency over a defined time frame
	*
	* @param string $targetUnit
	* @param integer $timeFrame 
	*
	* @return array 
	*/
	public function priceSummary( $targetUnit='BTC', $timeFrame=NULL )
	{
		$marketData = new marketData();

		$timePeriod = $this->_convertTimeFrame( $timeFrame );
		$priceSummary = $marketData->priceSummary( $targetUnit, $timePeriod, $this->_selectedCurrency );

		if ($priceSummary) {
			$priceSummary['price_unit'] = $this->_selectedCurrency;

			return array(
							'error' => null, 
							'data' =>  $priceSummary
						);			
		} else {
			return array('error' => 'Not enough data to provide average price.', 'data' =>  null);
		}
	}	

	/**
	* Get a price data for a currency over a given currency over a defined time frame
	*
	* @param string $targetUnit
	* @param integer $timeFrame 
	*
	* @return array 
	*/
	public function priceData( $targetUnit='BTC', $timeFrame=NULL )
	{
		$marketData = new marketData();

		$timePeriod = $this->_convertTimeFrame( $timeFrame );
		$priceData = $marketData->priceData( $targetUnit, $timePeriod, $this->_selectedCurrency );

		if ($priceData) {
			return array(
							'error' => null, 
							'data' =>  $priceData
						);			
		} else {
			return array('error' => 'No price data available for the selected currency over this period.', 'data' =>  null);
		}
	}	

	/**
	* Update all of the active cryptocurrencies from the exchange
	*
	* @return array
	*/
	public function updateAll()
	{
		$marketData = new marketData();

		$activeExchanges = $marketData->getActiveExchanges();

		foreach ($this->_activeCoins as $activeCoin) {
			foreach ($activeExchanges as $activeExchange) {
				if ($activeExchange['library']) {
					$exchangeLibrary = new $activeExchange['library'];

					$apiResp = $exchangeLibrary->getTick( $activeCoin, $this->_selectedCurrency );
					$marketObj = $exchangeLibrary->parseJson( $apiResp );

					$tickerRow = $marketData->saveTicker( $marketObj, $activeExchange['id'], $this->_selectedCurrency );
				}
			}
		}

		return array('data' => 'All currencies updated', 'error' => false);		
	}

	/**
	* Create an error object
	*
	* @param string $errorMsg
	*
	* @return array $apiResp
	*/
	public function routingError( $errorMsg='Ticker unit invalid' ) {
		
		$apiResp = array(
						'error' => $errorMsg, 
						'data' => null
				);
		
		return $apiResp;
	}

	/**
	* Return a time period in seconds 
	*
	* @param integer $timeSeconds
	*
	* @return array $startFinish
	*/
	protected function _convertTimeFrame( $timeSeconds = NULL ) 
	{
		$timeNow = time();

		if (!$timeSeconds) {
			$timeSeconds = $timeNow - ( 3600 * 24 );
		} else {
			$timeSeconds = $timeNow - $timeSeconds;
		}

		$startFinish = array(
								'start' => $timeSeconds,
								'end' => $timeNow
							);

		return $startFinish;
	}	
}