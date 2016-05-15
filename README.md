# BTC Market Data

Simple PHP aggregator for Bitcoin market data from the Australian [btcmarkets.net](https://btcmarkets.net/) Bitcoin exchange.

# Why would I want this?
This application can be used to collect market data for trend analysis or maybe you just want an easy way to find out current price of Bitcoin in AUD.

# Application Setup:

Create a MySQL database for the application to use, and import the structure from the sql/dump.sql file.

Add the API key for your BTC Markets account and change the database parameters to match your environment in the config/config.ini

Install [Composer](https://getcomposer.org/) so you can get all of the needed dependencies if you don't have it on your system already. Then run "composer install" to fetch the required dependencies

# Existing Routes:

**Current Price**
* /current-price/BTC - Returns the current Bitcoin ticker price.
* /current-price/LTC - Same as the above route but for Litecoin
* /current-price/ETH - Same as the above route but for Ethereum

**Average Price**
* /average-price/BTC - Returns the average Bitcoin market price across the datapoints in the database
* /average-price/LTC - Same as the above route but for Litecoin
* /average-price/ETH - Same as the above route but for Ethereum

**Latest Trades**
* /latest-trades - Returns information about the latest Bitcoin trades on the exchange
* /latest-trades/LTC - Same as the above route but for Litecoin
* /latest-trades/ETH - Same as the above route but for Ethereum

**Order Book**
* /order-book - Get the exchange order book for Bitcoin trades
* /order-book/BTC - Get the exchange order book for Bitcoin trades
* /order-book/LTC - Same as the above route but for Litecoin
* /order-book/ETH - Same as the above route but for Ethereum

**Price Summary**
* /price-summary/ - Get the min, max and average BTC price over the last 24hrs
* /price-summary/BTC - Same as above but explicitly stating you want the BTC summary
* /price-summary/LTC - Same as above but for Litecoin
* /price-summary/ETH - Same as above but for Ethereum
* /price-summary/currency/timeframe - Same as above for each currency but limited to a particular time frame denoted in seconds i.e /price-summary/LTC/3600 would get a price sumary of Litecoin over the last hour.

**Misc**
* /update-all - Update the ticker prices for all of the active cryptocurrencies

# Required Libraries:

Dependencies are for the application are managed by Composer. The external libraries needed are as follows:

* [Redbean ORM](http://www.redbeanphp.com/)
* [Klein](https://github.com/chriso/klein.php)

Further information can be found at the wiki for the BTC markets API on github:

* [BTC Markets API](https://github.com/BTCMarkets/API)

# Licence

Copyright (C) 2016 [Anthony Mills](http://www.anthony-mills.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.