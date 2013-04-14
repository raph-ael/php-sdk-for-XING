# What is php-sdk-for-XING?

PHP SDK for XING is a client library for connecting to the Xing ReSTful API.

This is **no official package** from XING AG!

You can find more information at https://dev.xing.com/ about the Xing API.

# Requirements

PHP SDK for XING requires at least PHP 5.3 and the following packages:

  * symfony/http-foundation V2.2.*@dev
  * guzzle/guzzle V3.1 or up

To use the package, you have to register at https://dev.xing.com/ and register
yourself for a Xing application to get the consumer key/secret which you have to
use with this package.

# Installation

The best way to install php-sdk-for-XING is through composer:

1. Download the [`composer.phar`](https://getcomposer.org/composer.phar) executable or use the installer.

    ``` sh
    $ curl -sS https://getcomposer.org/installer | php
    ```

2. add the following to your composer.json

    ``` javascript
    {
        "require": {
        	"bjoernschotte/php-sdk-for-XING": "dev-master"
        }
    }
    ```

3. Run Composer: `php composer.phar install`

And you should be done.

# Example usage

```php
<?php
// OAuth application configuration
$conf = array(
    'consumer_key' => '<insert your consumer key>',
    'consumer_secret' => '<insert your consumer secret>',
    'token' => false,
    'token_secret' => false,
    'callback' => '<insert http(s) callback url>',
);

/* ... */

// request token and authorize
$client = \BjoernSchotte\XingClient::factory($conf);
$client->XingRequestToken();
```

For a full working example, please refer to .

# License

This work is licensed under Apache 2.0 license. Please see [LICENSE] for further details.

# Contributing

If you want to contribute:

  * fork this repo
  * create a branch feature/featurename or bug/bugname
  * commit
  * send a pull request to the master branch of this repo and adhere to the [LICENSE]
  * bug me until your PR gets incorporated :-)

# TODOs

The package is currently in heavy development state. At least the following things are open:

  * add more commands from Xing API
  * create example application
  * write short tutorial and put it to gh-pages
