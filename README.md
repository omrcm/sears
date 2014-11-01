Features
========

The AntiMattr Sears project is a library that facilitates interaction with the various Sears APIs.

It currently allows you to:

+ Read new orders from Sears
+ Push to Sears tracking information for completed orders
+ Manage simple product listings

There is no support for configurable products at this time. 
Configurable products are products with variations such as different sizes or colors. 

Installation
============

Add the following to your composer.json file:

```json
{
    "require": {
        "antimattr/sears": "~1.0@stable"
    }
}
```

Install the libraries by running:

```bash
composer install
```

If everything worked, the Sears Client can now be found at vendor/antimattr/sears.

Interacting with the Sears Client
=================================

```php
$product = $ObjectFactory->getInstance("AntiMattr\Sears\Model\Product");
$product->setId('foo');
$products = new ArrayCollection; // Doctrine collection
$products->add($product);
$SearsClient->updateProducts($products);
```

Pull Requests
=============

Pull Requests - PSR Standards
-----------------------------

Please use the pre-commit hook to fix all code to PSR standards

Install once with

```bash
./bin/install.sh 
Copying /antimattr-sears/bin/pre-commit.sh -> /antimattr-sears/bin/../.git/hooks/pre-commit
```

Pull Requests - Testing
-----------------------

Please make sure tests pass

```bash
$ vendor/bin/phpunit tests
```

Pull Requests - Code Sniffer and Fixer
--------------------------------------

Don't have the pre-commit hook running, please make sure to run the fixer/sniffer manually

```bash
$ vendor/bin/php-cs-fixer fix src/
$ vendor/bin/php-cs-fixer fix tests/
```
