#Autoloader

Autoloader is a PHP class autoloader which is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compliant.  
Moreover, it supports namespace and class aliasing to simplify refactoring or to simplify class name at runtime.

##Requierements
To use it, you should use a PHP version ≥ 5.3.  
There is no other requierement.

##How to use it?
The file `autoloader.php` returns an anonymous function which should be used to setup the autolaoder.
This anonymous function takes four arguments:

1. An array where each key is a namespace and each value the directory which contains classes in this namespace;
2. An optional file format, its default value is `%s.php`;
3. An optional array where each key is a namespace and each value is an another namespace, to define aliasing on namespaces. Its default value is `null`;
4. An optional array where each key is a fully qualified class name (whitout leading `\`) and each value is an another fully qualified class name (whitout leading `\`), to define aliasing on classes. Its default value is `null`.

So, to use this anonymous function, just do:

```php
<?php

$autoloader = include('path/to/autoloader.php');
$autoloader(array( 'your\namespace\here' =>  __DIR__ . '/path/to/classes/directory', 'an\another\namespace' =>  __DIR__ . '/path/to/another/classes/directory' ));
```

To avoid variable, you can use `call_user_func_array()`:

```php
<?php

call_user_func_array(include(__DIR__ . '/autoloader.php'), array(array('your\namespace\here' =>  __DIR__ . '/path/to/classes/directory', 'an\another\namespace' =>  __DIR__ . '/path/to/another/classes/directory')));
```
