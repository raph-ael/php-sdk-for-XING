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

# Example usage

```php
<?php
// request token and authorize
$client = \BjoernSchotte\XingClient::factory($conf);
$client->XingRequestToken();
```

# License

# Contributing

If you want to contribute:

  * fork this repo
  * create a branch feature/featurename or bug/bugname
  * commit
  * send a pull request to the master of this repository
  * bug me until your PR gets incorporated :-)

# TODOs

The package is currently in heavy development state. At least the following things are open:

  * create example application
  * write short tutorial
