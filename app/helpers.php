<?php 

function set_active($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

//Render select
function getOptions($options) {
    $results = [];
    foreach (config($options) as $option) {
        $results[$option] = trans($options . '.' . $option);
    }

    return $results;
}
