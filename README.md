# lazada-carts
My test about the shipping fee

## Frameworks & PHP:

- Slim 3: a micro framework for PHP and it's lightweight.
- PHP 5.6
- Jquery 3.2
- Bootstrap 3.3.7

## Cart.php & Cart.tpl:

I wrote all the code by my way in this file, please take a moment to check it out, thanks!

## MySQL

Please import lazada.sql to your database.

## Micro Service:

To run the micro-service API, please follow bellow steps: (.env file is located at Service/.env)

```
console$: cd Services
console$: php -S localhost:8080 -t public public/index.php
```

## RESTfull API

```
Username and password for API Authencation is located at Services/.env, please check it out!

GET http://localhost:8080/api/ping (it's used to ping the API Service is still alive or not)
GET http://localhost:8080/api/cart/{cartID} (Get all items in the cart)
POST http://localhost:8080/api/login (Authenticaton)
POST http://localhost:8080/api/shipping/fee (Get the shipping to this delivery code, the source is located at Service/src/routes.php, line 70)

```

## POSTMAN Collection for testing:

```
{
	"variables": [],
	"info": {
		"name": "Lazada",
		"_postman_id": "37e1ebc5-d6ad-bef6-d795-befbf1aae5fd",
		"description": "",
		"schema": "https://schema.getpostman.com/json/collection/v2.0.0/collection.json"
	},
	"item": [
		{
			"name": "Login",
			"request": {
				"url": "http://localhost:8080/api/login",
				"method": "POST",
				"header": [
					{
						"key": "Content-Type",
						"value": "application/x-www-form-urlencoded",
						"description": ""
					}
				],
				"body": {
					"mode": "urlencoded",
					"urlencoded": [
						{
							"key": "username",
							"value": "admin",
							"type": "text"
						},
						{
							"key": "password",
							"value": "PuPktVTEm3'}`jxp",
							"type": "text"
						}
					]
				},
				"description": "Login"
			},
			"response": []
		},
		{
			"name": "Shipping Fee",
			"request": {
				"url": "http://localhost:8080/api/shipping/fee/702000",
				"method": "GET",
				"header": [
					{
						"key": "Authorization",
						"value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwicGFzc3dvcmQiOiIwMzAyNGRmYmM0M2M5ZDNjMWRjYTI4OGQ4N2Q2NzE3YiJ9.CwEOIwiX1LVvNIAbz8Ud3jXKc5nZLGJTBciJnEcFdnM",
						"description": ""
					}
				],
				"body": {},
				"description": "Shipping Fee"
			},
			"response": []
		},
		{
			"name": "Ping",
			"request": {
				"url": "http://localhost:8080/api/ping",
				"method": "GET",
				"header": [],
				"body": {},
				"description": ""
			},
			"response": []
		},
		{
			"name": "Get Cart Items",
			"request": {
				"url": "http://localhost:8080/api/cart/cart1234",
				"method": "GET",
				"header": [
					{
						"key": "Authorization",
						"value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwicGFzc3dvcmQiOiIwMzAyNGRmYmM0M2M5ZDNjMWRjYTI4OGQ4N2Q2NzE3YiJ9.CwEOIwiX1LVvNIAbz8Ud3jXKc5nZLGJTBciJnEcFdnM",
						"description": ""
					}
				],
				"body": {},
				"description": ""
			},
			"response": []
		},
		{
			"name": "Get Shipping Fee",
			"request": {
				"url": "http://localhost:8080/api/shipping/fee",
				"method": "POST",
				"header": [
					{
						"key": "Authorization",
						"value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwicGFzc3dvcmQiOiIwMzAyNGRmYmM0M2M5ZDNjMWRjYTI4OGQ4N2Q2NzE3YiJ9.CwEOIwiX1LVvNIAbz8Ud3jXKc5nZLGJTBciJnEcFdnM",
						"description": ""
					},
					{
						"key": "Content-Type",
						"value": "application/x-www-form-urlencoded",
						"description": ""
					}
				],
				"body": {
					"mode": "urlencoded",
					"urlencoded": [
						{
							"key": "cart_id",
							"value": "cart1234",
							"type": "text"
						},
						{
							"key": "items[]",
							"value": "1",
							"type": "text"
						},
						{
							"key": "items[]",
							"value": "2",
							"type": "text"
						},
						{
							"key": "postal_code",
							"value": "10000",
							"type": "text"
						}
					]
				},
				"description": ""
			},
			"response": []
		}
	]
}
```
