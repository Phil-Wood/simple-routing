<?php

require "../vendor/autoload.php";

use App\Core\Routing;


Routing::setError404(function(){
	echo "Not Found";
});

Routing::set('/', function(){
	echo "hello /";
});

Routing::set('/boom', function(){
	echo "hello boom";
});


Routing::match();

/*
use App\Core\Url;
use App\Core\Helper;

$url 		= new Url();

$full_url 	= $url->getUrl();
$url_parts	= $url->getUrlArray();
$scheme 	= $url->getScheme();
$host 		= $url->getHost();
$paths 		= $url->getPaths();
$query 		= $url->getQuery();

$helper 	= Helper::Instance();

$helper::raw($full_url);
$helper::raw($url_parts);
$helper::raw($scheme);
$helper::raw($host);
$helper::raw($paths);
$helper::raw($query);
*/