<?php

// Print objects & arrays in a more readable format.
function print_nice($var, $die = false)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    if ( $die ) {
        die();
    }
}
