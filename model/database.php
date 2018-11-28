<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/21/2018
 * Time: 7:44 PM
 */

    $dbinfo = 'mysql:host=localhost; dbname=socialbook';
    $username = 'web';
    $password = 'NevermindTheRat';

    try{
        $database = new PDO( $dbinfo, $username, $password );
    } catch( PDOException $e ){
        $error_message = $e->getMessage();

        //DEBUG
        echo $error_message;
        exit();
    }