<?php 
/**
* Application route deifinitions for Klien Framework
**/

// Get the current ticker price from the API
$klein->respond('GET', '/current-price', function () 
{
	$btcApp = new \btcMarkets\btcApp();
	$apiResp = $btcApp->updatePrice('BTC');		

    return json_encode($apiResp);
});

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
		return json_encode( 
							array(
									'error' => null, 
									'data' => $apiResp
								)
						);
	} else {
		return json_encode( 
							array(
									'error' => 'Unable to retrieve active exchanges', 
									'data' => null
								)
						);
	}
    return json_encode($apiResp);
});

$klein->respond('GET', '/current-price/[:targetUnit]', function ($request ) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {

			$apiResp = $btcApp->getPrice( strtoupper($request->targetUnit) );

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});

// Get the latest trades from the API
$klein->respond('GET', '/latest-trades', function () 
{
	$btcApp = new \btcMarkets\btcApp();
	$apiResp = $btcApp->latestTrades();		

    return json_encode($apiResp);
});

$klein->respond('GET', '/latest-trades/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {

			$apiResp = $btcApp->latestTrades( 
												strtoupper($request->targetUnit) 
											);

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});

// Get the order book from the API
$klein->respond('GET', '/order-book', function () 
{
	$btcApp = new \btcMarkets\btcApp();

	$apiResp = $btcApp->orderBook();

	return json_encode($apiResp);
});

$klein->respond('GET', '/order-book/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->orderBook( 
											strtoupper($request->targetUnit) 
										 );

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});

// Get the average ticker price from the API
$klein->respond('GET', '/average-price', function () {	
	$btcApp = new \btcMarkets\btcApp();

	$apiResp = json_encode($btcApp->averagePrice());
    return $apiResp;
});

$klein->respond('GET', '/average-price/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->averagePrice( strtoupper($request->targetUnit) );

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});

// Start routes related to price summary
$klein->respond('GET', '/price-summary', function () {	
	$btcApp = new \btcMarkets\btcApp();

	$apiResp = json_encode($btcApp->priceSummary());
	
    return $apiResp;
});

$klein->respond('GET', '/price-summary/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->priceSummary( strtoupper($request->targetUnit) );

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});

$klein->respond('GET', '/price-summary/[:targetUnit]/[:timeFrame]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit) && (is_numeric($request->timeFrame))) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {

			$apiResp = $btcApp->priceSummary( strtoupper($request->targetUnit), $request->timeFrame );

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});

// Start routes related to price data
$klein->respond('GET', '/price-data', function () {	
	$btcApp = new \btcMarkets\btcApp();

	$apiResp = json_encode($btcApp->priceData('BTC'));
	
    return $apiResp;
});

$klein->respond('GET', '/price-data/[:targetUnit]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit)) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {
			$apiResp = $btcApp->priceData( strtoupper($request->targetUnit) );

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});

$klein->respond('GET', '/price-data/[:targetUnit]/[:timeFrame]', function ($request) 
{
	$btcApp = new \btcMarkets\btcApp();

	if (isset($request->targetUnit) && (is_numeric($request->timeFrame))) {
		if ( in_array(strtoupper($request->targetUnit), $btcApp->getActive() )) {

			$apiResp = $btcApp->priceData( strtoupper($request->targetUnit), $request->timeFrame );

 			return json_encode($apiResp);
		} else {
			return 'Ticker unit invalid';			
		}
	}

   	return 'Ticker unit not found';
});