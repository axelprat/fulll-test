<?php

function fizzBuzz ($max) {
    if (filter_var($max, FILTER_VALIDATE_INT) === false) {
        echo "'$max' is not an integer";
        return false;
    }

    $value = 1;
    while ($value <= $max) {
        $display = $value;
        if ($value % 3 === 0 && $value % 5 === 0) {
            $display = 'FizzBuzz';
        } elseif ($value % 3 === 0) {
            $display = 'Fizz';
        } elseif ($value % 5 === 0) {
            $display = 'Buzz';
        }
        echo $display . PHP_EOL;
        ++$value;
    }

    return true;
}

$input = 25;
if (!empty($argv[1])) {
    $input = $argv[1];
}

fizzBuzz($input);