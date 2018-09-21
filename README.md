CurlOP Library
=========================

Description
===========

A simple encapsulation for Curl that aims for simplicity.

Features
========

* PSR-4 autoloading compliant structure
* Unit-Testing with PHPUnit
* Object oriented curl connections
* Authorization support
* Concatenation support

Requirements
============

* PHP >= 7.1
* CURL Extension
* phpunit/phpunit

Installation
============

`composer require Quantik/CurlOP`

Usage
=====

First step is to require the namespace using `use Agencia-Quantik/CurlOP` inside your file. Now you can just create an object such as: `$var = new CurlOP('target-url');` Here are some methods you may use:

* setHeader($string)
Here you can add a header parameter, don't worry about adding authentication here, since we will handle this for you. Ex: `$var->setHeader('content-type: application/json')`

* setHeaders($array = [])
This serves to overwrite the entire header that is going to be sent with a new array, you can populate it in the argument. Ex: `$var->setHeaders(['content-type: application/json','accept: */*'])`

* setPost($arg1, $arg2 = "")
There are two ways you can add variables to the POST body, if you pass only one argument, (Ex: `$var->setPost('value')`), it will be passed as a numeric key, if you pass two arguments, (Ex: `$var->setPost('key','value')`), the first argument will serve as a key and the second one as the variable actual value.

* method($method)
You can specify the method as a string or as a integer, here is the list of all the options:
  * 0  - GET
  * 1  - POST
  * 2  - PUT
  * 3  - PATCH
  * 4  - DELETE
  * 5  - COPY
  * 6  - HEAD
  * 7  - OPTIONS
  * 8  - LINK
  * 9  - UNLINK
  * 10 - PURGE
  * 11 - LOCK
  * 12 - UNLOCK
  * 13 - PROPFIND
  * 14 - VIEW
(You may also use POSTMAN order list, I use it as reference)

* auth($authType)
You can specify the method as a string or as a integer, here is the list of all the options:
  * 0 - None
  * 1 - Bearer
  * 2 - Basic
  * 3 - Digest (NYI)
  * 4 - OAuth1 (NYI)
  * 5 - OAuth2
  * 6 - Hawk (NYI)
  * 7 - AWS (NYI)
(You may also use POSTMAN order list, I use it as reference)

* token($string)
If you choose to use an authentication that requires token, you may fill it here, you don't need to insert `{{TokenType}} {{Token}}`, just the token.

* login($username, $password = "")
If you choose to use an authentication that requires basic login and password, you may fill it here.

* responseType($responseType = 1)
You can specify the method as a string or as a integer, here is the list of all the options:
  * 0 - None (won't parse)
  * 1 - JSON
  * 2 - XML

Credits
=======

* Joel Oliveira for all the support and things that teach me
* Fernando Sousa for all the support also