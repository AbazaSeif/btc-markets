<?php
namespace btcmarkets;

use \RedBeanPHP\R;

class marketData {

	public function __construct()
	{
		R::setup( 'mysql:host=localhost;dbname=' . DB_NAME, DB_USER, DB_PASS );
	}

	public function __destruct()
	{
		R::close();
	}

	/**
	* Get the latest price for a currency
	*
	* @param string $targetUnit
	* @param string $priceUnit	
	* @param integer $resultLimit	
	*
	* @return object $coinPrice
	*/
	public function getPrice( $targetUnit = 'BTC', $priceUnit = 'AUD', $resultLimit = 1 )
	{
		$coinPrice = R::find('marketdata',
				       ' instrument = :targetUnit AND price_unit = :priceUnit ORDER BY timestamp DESC LIMIT :resultLimit', 
				            array( 
				                ':priceUnit' => $priceUnit,
				                ':targetUnit' => $targetUnit,
				                ':resultLimit' => $resultLimit
				            )
		               );

		if ($coinPrice) {
			return $coinPrice;
		}
	}

	/**
	* Save ticker data to the database
	*
	* @param object $tickerData
	* @param object $priceUnit	
	* 
	* @return array 
	*/
	public function saveTicker( $tickerData, $priceUnit = 'AUD' )
	{

		$priceObj = R::dispense("marketdata");

		$priceObj->best_bid = $tickerData->bestBid;
		$priceObj->best_ask = $tickerData->bestAsk;
		$priceObj->price_unit = $priceUnit;		
		$priceObj->last_price = $tickerData->lastPrice;
		$priceObj->instrument = $tickerData->instrument;
		$priceObj->timestamp = $tickerData->timestamp;
		$priceObj->volume = $tickerData->volume24h;

		R::store( $priceObj );

		return $priceObj->export();
	}

	/**
	* Save the latest trades into the database
	* 
	* @param object $tradeData
	* @param string $cryptoUnit
	* @param string $priceUnit
	*
	* @return object $savedRows
	*/
	public function updateTrades( $tradeData, $cryptoUnit, $priceUnit = 'AUD' )
	{
		$savedRows = 0;
		
		$tradeData = json_decode($tradeData);

		if (count($tradeData) > 0) {

			foreach($tradeData as $btcTrade) {
				$existingRow = R::findOne('markethistory', ' transid = ?', array( $btcTrade->tid ));

				if (!$existingRow) {
					$tradeObj = R::dispense("markethistory");

					$tradeObj->crypto_unit = $cryptoUnit;
					$tradeObj->transid = $btcTrade->tid;
					$tradeObj->amount = $btcTrade->amount;
					$tradeObj->price = $btcTrade->price;					
					$tradeObj->timestamp = $btcTrade->date;	

					R::store( $tradeObj );			

					$savedRows++;	
				}	
			}
		}	

		return $savedRows;
	}

	/**
	* Get the average ticker price
	* 
	* @param string $targetUnit
	* @param array $timeFrame
	* @param string $priceUnit
	*
	* @return integer
	*/
	public function averageTickerPrice( $targetUnit='BTC', $timeFrame=NULL, $priceUnit = 'AUD' )
	{		

		$avgPrice = R::getCell(
								"SELECT AVG(last_price) FROM marketdata WHERE instrument = :cryptoUnit " .
								" AND price_unit = :priceUnit AND timestamp > :startTime AND timestamp < :endTime",
									array(
										':cryptoUnit' => $targetUnit,
										':startTime' => $timeFrame['start'],
										':endTime' => $timeFrame['end'],
										':priceUnit' => $priceUnit									
									)
					);

		if (($avgPrice) && (is_numeric($avgPrice))) {
			return number_format($avgPrice, 4);			
		}
	}	

	/**
	* Produce a price summary for a given time frame i.e BTC price over the last 24hr etc
	* 
	* @param string cryptoUnit
	* @param array timeFrame 
	* @param string $priceUnit	
	*
	* @return array priceSummary
	*/
	public function priceSummary( $cryptoUnit='BTC', $timeFrame, $priceUnit = 'AUD' )
	{

		$priceSummary = R::getRow(
									"SELECT MIN(last_price) AS min_price, ROUND(AVG(last_price),2) AS avg_price, MAX(last_price) AS max_price FROM (SELECT last_price FROM marketdata WHERE instrument = :cryptoUnit AND price_unit = :priceUnit AND timestamp > :startTime AND timestamp < :endTime  LIMIT 10) tmp", 
									array(
										':cryptoUnit' => $cryptoUnit,
										':startTime' => $timeFrame['start'],
										':endTime' => $timeFrame['end'],
										':priceUnit' => $priceUnit												
									)
								  );
		if ( $priceSummary ) {
			return $priceSummary;
		}
	}

	/**
	* Get all the price data for a currency within a given timeframe
	*
	* @param string $cyptoUnit
	* @param array $timeFrame 
	* @param string $priceUnit	
	*
	* @return array priceSummary
	*/
	public function priceData( $cryptoUnit='BTC', $timeFrame, $priceUnit = 'AUD'  )
	{

		$priceData = R::getAll(
								"SELECT * FROM marketdata WHERE instrument = :cryptoUnit AND price_unit = :priceUnit AND timestamp > :startTime AND timestamp < :endTime ", 
								array(
									':cryptoUnit' => $cryptoUnit,
									':startTime' => $timeFrame['start'],
									':endTime' => $timeFrame['end'],
									':priceUnit' => $priceUnit										
								)
							);
		if ( $priceData ) {
			return $priceData;
		}
	}


}