# DO NOT USE - In Development

Sears
=======

The AntiMattr Sears project is a library that provides access to the Sears Marketplace API.

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

Features
========

 * Read New Orders (Working on it)
 * Update Product Catalog (TODO)
 * Update Inventory (Working on it)
 * Update Tracking Information (Working on it)
