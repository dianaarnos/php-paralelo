<?php

/**
 * Adaptado do exemplo dado em  https://github.com/krakjoe/parallel/blob/develop/README.md
 */

use parallel\Runtime;

$runtime = new Runtime();

$future = $runtime->run(function(){
    for ($i = 0; $i < 100; $i++)
        echo "*";

    return "fácil";
});

for ($i = 0; $i < 100; $i++) {
    echo ".";
}

printf("\nUsar o \\parallel\\Runtime é %s\n", $future->value());
