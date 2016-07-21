<?php 
/**
* Application route deifinitions for Klien Framework
**/
$klein->respond('GET', '/update-all', function () 
{
	$btcApp = new \btcMarkets\btcApp();
	$apiResp = $btcApp->updateAll();		

    return json_encode($apiResp);
});

$klein->respond('GET', '/active-exchanges', function () 
{
	$btcApp = new \btcMarkets\btcApp();
	$apiResp = $btcApp->getActiveExchanges();		

	if ($apiResp) {
		$apiResp =  array(
						'error' => null, 
						'data' => $apiResp
					);
	} else {
		$apiResp =	array(
							'error' => 'Unable to retrieve active exchanges', 
							'data' => null
					);
	}
    return json_encode($apiResp);
});

$klein->respond('GET', '/current-price/[:targetUnit]', function ($request ) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (!isset($request->targetUnit)) {
		$targetUnit = 'BTC';
	} else {
		$targetUnit = $request->targetUnit;
	}

	if ( in_array(strtoupper($targetUnit), $btcApp->getActive() )) {

		$apiResp = $btcApp->getPrice( strtoupper($targetUnit) );

		
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);
	}

	return json_encode($apiResp);
});

// Get the latest trades from the API
$klein->respond('GET', '/latest-trades/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {

			$apiResp = $btcApp->latestTrades( 
												strtoupper($request->targetUnit) 
											);

		} else {
			$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);
		}
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);		
	}


	return json_encode($apiResp);
});

// Get the order book from the API
$klein->respond('GET', '/order-book/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->orderBook( 
											strtoupper($request->targetUnit) 
										 );

		} else {
			$apiResp = array(
								'data' => null, 
								'error' => 'Ticker unit invalid'
							);
		}
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);	
	}


	return json_encode($apiResp);
});

// Get the average ticker price from the API
$klein->respond('GET', '/average-price/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->averagePrice( strtoupper($request->targetUnit) );

		} else {
			$apiResp = array(
								'data' => null, 
								'error' => 'Ticker unit invalid'
							);
		}
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);	
	}

	return json_encode($apiResp);
});

// Start routes related to price summary
$klein->respond('GET', '/price-summary/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->priceSummary( strtoupper($request->targetUnit) );

		} else {
			$apiResp = array(
								'data' => null, 
								'error' => 'Ticker unit invalid'
							);
		}
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);
	}

	return json_encode($apiResp);
});

$klein->respond('GET', '/price-summary/[:targetUnit]/[:timeFrame]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit) && (is_numeric($request->timeFrame))) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {

			$apiResp = $btcApp->priceSummary( strtoupper($request->targetUnit), $request->timeFrame );
		} else {
			$apiResp = array(
								'data' => null, 
								'error' => 'Ticker unit invalid'
							);
		}
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);	
	}


	return json_encode($apiResp);
});

// Start routes related to price data
$klein->respond('GET', '/price-data/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->priceData( strtoupper($request->targetUnit) );

		} else {
			$apiResp = array(
								'data' => null, 
								'error' => 'Ticker unit invalid'
							);
		}
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);
	}


	return json_encode($apiResp);
});

$klein->respond('GET', '/price-data/[:targetUnit]/[:timeFrame]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit) && (is_numeric($request->timeFrame))) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {

			$apiResp = $btcApp->priceData( strtoupper($request->targetUnit), $request->timeFrame );
		} else {
			$apiResp = array(
								'data' => null, 
								'error' => 'Ticker unit invalid'
							);
		}
	} else {
		$apiResp = array(
							'data' => null, 
							'error' => 'Ticker unit invalid'
						);	
	}


	return json_encode($apiResp);
});
