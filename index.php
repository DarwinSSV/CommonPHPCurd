<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

$language = $_GET['language'];
$operation = $_GET['operation'];

if ( !empty($language) && !empty($operation) ) {

    $language_directory = 'languages' . DIRECTORY_SEPARATOR . $language;

    if( file_exists( $language_directory ) ) {

        $operation_file = $language_directory . DIRECTORY_SEPARATOR . $operation . ".php";

        if( file_exists( $operation_file ) ) {

            $response = highlight_string( file_get_contents( $operation_file ) );
        } else {

            $response = 'No Operation File Found';
        }

        echo $response;
    } else {

        echo 'Invalid language';
    }
} else {
    
    echo 'None';
}

use DarwinS\CommonPHPCurd\CommonPHPCurd;

$main_obj = new CommonPHPCurd();