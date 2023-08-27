<?php

require_once('./vendor/autoload.php');
$client = new GuzzleHttp\Client();

$promises = [
	$client->getAsync('http://localhost')
			->then(function ($response)
	{ echo '10'; }),
	
	$client->getAsync('http://www.google.com')
			->then(function ($response)
	{ echo '20'; }),
	
	$client->getAsync('http://localhost')
			->then(function ($response)
	{ echo '30'; }),
	
	$client->getAsync('http://localhost')
			->then(function ($response)
	{ echo '40'; }),
	
	$client->getAsync('http://localhost')
			->then(function ($response)
	{ echo '50'; }),
	
	$client->getAsync('http://localhost')
			->then(function ($response)
	{ echo '60'; }),
	
	$client->getAsync('http://localhost')
			->then(function ($response)
{ echo '70'; }),
];

$results = GuzzleHttp\Promise\unwrap($promises);

// Please wait for a while to complete
// the requests(some of them may fail)
$results = GuzzleHttp\Promise\settle(
		$promises)->wait();
		
print "finish/over." . PHP_EOL;
?>
