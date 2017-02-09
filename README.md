# Routing

A simple php7.1 class to set routes and compare them to the url paths ( app/core/routing.php ). 
If a match is found, the callback is implemented - simple!

### Prerequisites

```
PHP 7.1

```

## Usage

```php
Routing::set('/', function(){
	echo "hello /";
});
Routing::match();
```
Set a custom error404 callback
```php
Routing::setError404(function(){
	echo "Not Found";
});
```

## Built With
* [url](https://github.com/Phil-Wood/url) - Url Class
* [Composer](https://getcomposer.org/) - Dependency Management

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
