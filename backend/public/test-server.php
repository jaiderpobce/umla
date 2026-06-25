<?php
header('Content-Type: text/plain; charset=utf-8');
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "\n";
echo "PATH_INFO: " . (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : 'not set') . "\n";
echo "QUERY_STRING: " . $_SERVER['QUERY_STRING'] . "\n";
