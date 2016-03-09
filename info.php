<?php

// Show all information, defaults to INFO_ALL
echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

echo ini_get('display_errors');

phpinfo();

?>