# WPPConnect Client

## Installation and usage

### Install via composer
```
composer require scalexy/wppconnect
```

### Add to .env
```
WPPCONNECT_SERVER_ENDPOINT="http://instance:port"
WPPCONNECT_SERVER_SECRET="*******"
```

### Add to config/services.php
```
'wppconnect' => [
	'endpoint' => env('WPPCONNECT_SERVER_ENDPOINT'),
	'secret' => env('WPPCONNECT_SERVER_SECRET'),
],
```

## Why

We wanted it, we built it.

## Opensource

We licensed under the MIT License so that anyone can use it. But we don't intend to actively develop it. You are free to fork it and continue development. PR(s) will probably be ignored. 

## Urgent help

If there is some small bug that you need fixed like adding a new param, open an issue and we'll look into it. Don't do it to request new features, we'll close it.

## Security issues

If there are any security issues, please mail us security@scalexy.com

## Features implemented

- Auth