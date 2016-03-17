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
	* @param integer $resultLimit
	*
	* @return object $coinPrice
	*/
	public function getPrice( $targetUnit = 'BTC', $resultLimit = 1 )
	{
		$coinPrice = R::find('marketdata',
				       ' instrument = :targetUnit ORDER BY timestamp DESC LIMIT :resultLimit', 
				            array( 
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
	* 
	* @return array $storedRow
	*/
	public function saveTicker( $tickerData )
	{

		$priceObj = R::dispense("marketdata");

		$priceObj->best_bid = $tickerData->bestBid;
		$priceObj->best_ask = $tickerData->bestAsk;
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
	*/
	public function updateTrades($tradeData)
	{
		$savedRows = 0;
		
		$tradeData = json_decode($tradeData);

		if (count($tradeData) > 0) {

			foreach($tradeData as $btcTrade) {
				$existingRow = R::findOne('markethistory', ' transid = ?', array( $btcTrade->tid ));

				if (!$existingRow) {
					$tradeObj = R::dispense("markethistory");

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
	*/
	public function averageTickerPrice( $targetUnit='BTC' )
	{		
		$avgPrice = R::getCell("SELECT AVG(last_price) FROM marketdata WHERE instrument = '$targetUnit'");

		if (($avgPrice) && (is_numeric($avgPrice))) {
			return number_format($avgPrice, 4);			
		}
	}	

}