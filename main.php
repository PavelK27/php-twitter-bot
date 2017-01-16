<?php
// Load API calls.
require_once( 'api-calls.php' );

// Bail early if API or its settings were not loaded.
if ( ! class_exists( 'TwitterAPIExchange' ) || empty( $forecast ) ) {
	return;
}

// Get DarkSky API response.
$response = $forecast->get(
    '43.7659095',
    '-79.4141207',
    null,
    array(
        'units' => 'si',
        'exclude' => array(
				'minutely', 
				'hourly', 
				'daily', 
				'alerts', 
				'flags',
        	),
        )
    );

// Compose tweet with weather data.
$tweet = 'It is ' . $response->currently->summary. ' with '. $response->currently->temperature . '°C in #Toronto now. Real feel is ' . $response->currently->apparentTemperature . '°C';

// Post tweet.
$url = "https://api.twitter.com/1.1/statuses/update.json";

$requestMethod = "POST";
 
$postfields = array(
    'status' => $tweet,
);
 
$twitter = new TwitterAPIExchange($twitter_settings);
echo $twitter->buildOauth($url, $requestMethod)
    ->setPostfields($postfields)
    ->performRequest();
