# Salecto API Library for Magento 2

# Overview
Magento 2 API Library is a PHP package designed to simplify interactions with the Magento 2 API. It provides an easy-to-use interface for performing common operations such as fetching and synchronizing orders. The library supports both Bearer authentication and OAuth 1.0 authentication.

# Features
- **REST API Integration**: Simplifies communication with Magento 2's REST API.
- **Authentication**: Supports Bearer tokens and OAuth 1.0 for secure API calls.
- **Order Management**: Provides methods to fetch and sync orders by integration ID.

# Authentication
The library supports two types of authentication:
1. **Bearer Token Authentication**: Recommended for most cases.
2. **OAuth 1.0 Authentication**: Necessary for specific use cases that require OAuth.

# Installation
You can install the library using Composer:
```
    composer require salecto2/magento2-api`
```

# Rest Api Example usage:

### Using Bearer token:
```
<?php
use Salecto\Magento2Api\Model\Order;

$baseUri = 'https://your-magento-domain.com/';
$authType = 'Bearer';
$credentials = 'your-bearer-token';

$order = new Order($baseUri, $authType, $credentials);

```

### Using OAuth 1.0 Authentication:
```
<?php
use Salecto\Magento2Api\Model\Order;

$baseUri = 'https://your-magento-domain.com/';
$authType = 'OAuth1';
$credentials = [
    'consumer_key'    => 'your-consumer-key',
    'consumer_secret' => 'your-consumer-secret',
    'token'           => 'your-token',
    'token_secret'    => 'your-token-secret',
];

$order = new Order($baseUri, $authType, $credentials);

```
