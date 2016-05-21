<?php
namespace btcMarkets;

use \btcMarkets\marketData;
use \btcMarkets\btcMarkets;

class btcApp {
	protected $_activeCoins = array('BTC', 'LTC', 'ETH');

	/**
	* Update the target ticker price for one currency
	*
	* @param string $targetUnit
	*/
	public function updatePrice($targetUnit = 'BTC')
	{
		$btcMarkets = new btcMarkets();

		$apiResp = $btcMarkets->getTick( $targetUnit );

		$marketObj = $btcMarkets->parseJson( $apiResp );

		$marketData = new marketData();
		$tickerRow = $marketData->saveTicker( $marketObj );

		return $tickerRow;
	}

	/**
	* Get the latest ticker price for a currency
	*
	* @param string $targetUnit
	*/
	public function getPrice($targetUnit = 'BTC')
	{
		$marketData = new marketData();
		$tickerRow = $marketData->getPrice( $targetUnit );

		return $tickerRow;
	}

	/**
	* Get an object containing the latest trades from the exchange
	*
	* @return string
	*/
	public function latestTrades( $targetUnit='BTC' )
	{
		$btcMarkets = new btcMarkets();

		$apiResp = $btcMarkets->getTrades( $targetUnit );

		$marketData = new marketData();
		$tickerRow = $marketData->updateTrades( $apiResp, $targetUnit );

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

		$apiResp = $btcMarkets->getOrderBook( $targetUnit );

		//$marketData = new marketData();
		//$tickerRow = $marketData->updateTrades( $apiResp );

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
	public function averagePrice( $targetUnit='BTC', $timeFrame=FALSE )
	{
		$marketData = new marketData();
		$avgPrice = $marketData->averageTickerPrice( $targetUnit );

		if ($avgPrice) {
			return array(
							'error' => null, 
							'data' =>  array('price' => $avgPrice)
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
	public function priceSummary( $targetUnit='BTC', $timeFrame=FALSE )
	{
		$marketData = new marketData();

		if ($timeFrame) {
			$priceSummary = $marketData->priceSummary( $targetUnit, $timeFrame );
		} else {
			$priceSummary = $marketData->priceSummary( $targetUnit );			
		}

		if ($priceSummary) {
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
	public function priceData( $targetUnit='BTC', $timeFrame=FALSE )
	{
		$marketData = new marketData();

		if ($timeFrame) {
			$priceData = $marketData->priceData( $targetUnit, $timeFrame );
		} else {
			$priceData = $marketData->priceData( $targetUnit );			
		}

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
		$btcMarkets = new btcMarkets();
		$marketData = new marketData();

		foreach ($this->_activeCoins as $activeCoin) {
			$apiResp = $btcMarkets->getTick( $activeCoin );

			$marketObj = $btcMarkets->parseJson( $apiResp );
			$tickerRow = $marketData->saveTicker( $marketObj );
		}


		return array('data' => 'All currencies updated', 'error' => false);		
	}
}