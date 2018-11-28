<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/25/2018
 * Time: 1:55 AM
 */

$email = filter_input( INPUT_GET, 'email' );

if( $email == null ){
    echo "No email entered";
    exit;
}

// TODO check against DB
require_once( 'model/database.php' );
require_once( 'model/userFunctions.php' );

$result = checkEmailRegistered( $database, $email );

if( $result === true ){
    echo 'true';
    exit;
}

if( $result === false ){
    echo 'false';
    exit;
}