<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 3:01 PM
 */

require_once( 'model/userFunctions.php' );

$userID = filter_input( INPUT_GET, 'user' );

if( $userID === null || strlen( $userID ) < 1 ){
    header( 'Location: .' );
}

$viewingUser = fetchUserByID( $database, $userID );
$posts = fetchPostsFor( $database, $viewingUser->id );