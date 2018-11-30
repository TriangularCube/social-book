<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 12:53 AM
 */

require_once( 'model/constants.php' );

$userImagePath = DEFAULT_IMAGE_PATH;

if( isset($pathUser) && $pathUser->imagePath != null ){
    $userImagePath = $pathUser->imagePath;
}