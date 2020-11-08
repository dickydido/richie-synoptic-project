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

function edit_session($action, $session)
{
    if ($action == 'clear') {
        session_unset($session);
    } elseif ($action == 'add') {
        $session = true;
    }

    // echo '<div class="redirect"></div>';
}
