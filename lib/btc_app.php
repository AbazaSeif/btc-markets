<?php
namespace btcMarkets;

use \btcMarkets\marketData;
use \btcMarkets\btcMarkets;

class btcApp {
	
	/**
	* Get the target ticker price
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
	* Get an object containing the latest trades from the exchange
	*
	* @return string
	*/
	public function latestTrades( $targetUnit='BTC' )
	{
		$btcMarkets = new btcMarkets();

		$apiResp = $btcMarkets->getTrades( $targetUnit );

		$marketData = new marketData();
		$tickerRow = $marketData->updateTrades( $apiResp );

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
	*
	* @return array 
	*/
	public function averagePrice( $targetUnit='BTC' )
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
}