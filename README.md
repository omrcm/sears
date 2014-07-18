# DO NOT USE - In Development

Features
========

The AntiMattr Sears project is a library that facilitates interaction with the various Sears APIs.

It currently allows you to:

+ Read new orders from Sears
+ Push to Sears tracking information for completed orders
+ Manage simple **DSS product** listings

We are currently working on tools to manage **Marketplace product** listings. There is no
 support for configurable products at this time. Configurable products are products with
 variations such as different sizes or colors. 


Installation
============

Use composer to install

```bash
composer install
composer update --dev # for phpunit and php cs fixer
```

Please use the pre-commit hook to run fix code to PSR standard

Install once with

```bash
./bin/install.sh 
Copying /sears/bin/pre-commit.sh -> /payment/bin/../.git/hooks/pre-commit
```

Testing
=======

```bash
$ vendor/bin/phpunit 
```

Code Sniffer and Fixer
======================

```bash
$ vendor/bin/php-cs-fixer fix src/
$ vendor/bin/php-cs-fixer fix tests/
```


Interacting with the Sears Client
=================================

```php
$product = $ObjectFactory->getInstance("AntiMattr\Sears\Model\Product");
$product->setId('foo');
$products = new ArrayCollection; // Doctrine collection
$products->add($product);
$SearsClient->updateProducts($products);
```

