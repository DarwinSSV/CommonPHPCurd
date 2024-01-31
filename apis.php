<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

namespace APIS;

$language = $_GET['language'];
$operation = $_GET['operation'];

if (!empty($language) && !empty($operation)) {

    

    if (strtolower($language) == 'php') {

        switch ($operation) {

            case 'insert':
                $response = highlight_string( file_get_contents('src/php/insert.php') );
                break;
            default:
                $response = file_get_contents(__FILE__);
                break;
        }

        echo $response;
    } else {
        echo 'Invalid language';
    }
} else {
    echo 'None';
}
?>