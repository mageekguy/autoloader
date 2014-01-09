#Autoloader

Autoloader is a PHP class autoloader which is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compliant.  
Moreover, it supports namespace and class aliasing to simplify refactoring or to simplify class name at runtime.

##Requirements
To use it, you should use a PHP version ≥ 5.3.  
There is no other requirement.

##How to use it?
The file `autoloader.php` returns an anonymous function which should be used to setup the autoloader.
This anonymous function takes four arguments:

1. An array where each key is a namespace and each value is the directory which contains classes in this namespace,
2. An optional file format, its default value is `%s.php`,
3. An optional array where each key is a namespace and each value is an another namespace, to define aliasing on namespaces. Its default value is `null`,
4. An optional array where each key is a fully qualified class name (whitout leading `\`) and each value is an another fully qualified class name (whitout leading `\`), to define aliasing on classes. Its default value is `null`.

So, to use this anonymous function, just do:

```php
<?php

$autoloader = include 'path/to/autoloader.php';
$autoloader(array( 'your\namespace\here' =>  __DIR__ . '/path/to/classes/directory', 'an\another\namespace' =>  __DIR__ . '/path/to/another/classes/directory' ));
```

To avoid variable, you can use `call_user_func_array()`:

```php
<?php

call_user_func_array(include 'path/to/autoloader.php', array(array('your\namespace\here' =>  __DIR__ . '/path/to/classes/directory', 'an\another\namespace' =>  __DIR__ . '/path/to/another/classes/directory')));
```

##How to use namespaces aliasing
But what is namespace aliasing?  
Sometime, you're using class with a very long name, for example `the\best\frame\work\ever\done\is\mine\so\please\use\it\everywhere`.
In this case, you can use [importation](http://php.net/manual/en/language.namespaces.importing.php) to manipulate a short version of the class name in your code:

```php
<?php

use the\best\frame\work\ever\done\is\mine\so\please\use\it\everywhere as symfony;

$bestFramework = new symfony\controler();
```

However, you should use the `use` keyword in all your file where you're using this class, and it can be a pain in the ass.  
A better solution is the namespace aliasing feature of autoloader.  
With this feature, just define the namespace alias when you invoke its anonymous function, and you can use a short name for your class with a long name everywhere without using the `use` keywork:

```php
<?php

$autoloader = include('path/to/autoloader.php');
$autoloader(array( 'the\best\frame\work\ever\done\is\mine\so\please\use\it\everywhere' =>  __DIR__ . '/path/to/symfony' ),
	null, // use default php file name format, ie %s.php,
	array('the\best\frame\work\ever\done\is\mine\so\please\use\it\everywhere' => 'symfony')
);
```

So, after include of this code in your project, you can now write directly:

```php
<?php

require 'path/to/your/bootstrap/file/which/use/autoloader.php';

$bestFramework = new symfony\controler();
```

Call to the class `symfony` will be expanded at runtime automaticaly to `the\best\frame\work\ever\done\is\mine\so\please\use\it\everywhere` by autoloader.
Enjoy!

Moreover, it's a very handy feature when you're refactoring your code or to avoid BC break, because you can rename a namespace at runtime, without updating your code.  

##How to use classes aliasing
Classes aliasing is the same feature than namespaces aliasing, but for classes.
To using it, just use the last arguments of the anonymous function when you invoke it.
