My Travel Register
==================

Installation
------------

Firstly, clone **My Travel Register** repository:
``git clone https://github.com/freepius/my-travel-register.git``

Secondly, install [Composer] (the most popular dependency manager for PHP):
``php -r "readfile('https://getcomposer.org/installer');" | php``

Finally, install the project dependencies: ``php composer.phar install``

Tests
-----

To run the test suite, you need :

1. to install the *development* dependencies: ``php composer.phar install --dev``
1. to execute [PHPUnit]: ``vendor/bin/phpunit`` or ``vendor/bin/phpunit tests/My/Particular/Test.php``

License
-------

**My Travel Register** is licensed under the **CC0** license.


[Composer]: http://getcomposer.org
[PHPUnit]: https://phpunit.de
