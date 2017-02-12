<?php

require "../vendor/autoload.php";

use App\Core\Routing;
use App\Core\Url;

Routing::setError404(function(){
    echo "Not Found";
});

Routing::get('/', function(){
    echo "GET home";
});

Routing::post('/', function(){
    echo "POST home";
});

Routing::delete('/delete', function(){
    echo "DELETE /delete";
});

Routing::match();