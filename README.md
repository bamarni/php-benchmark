Usage
=====

Simple benchmark example, between the date() function and new DateTime::format() :

```php
<?php

require 'Benchmark.php';

$bench = new Benchmark;

$bench->addTarget('function', 'date', array('Y-m-d'));

$bench->addTarget('object', function() {
        $date = new DateTime;
        $date->format('Y-m-d');
    }
);

$result = $bench->execute();

/*
 * var_dump($result) :
 *
 *   array (size=2)
 *     'function' => string '100%' (length=4)
 *     'object'   => string '122%' (length=4) 
 */
```