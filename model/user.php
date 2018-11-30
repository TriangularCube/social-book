<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/21/2018
 * Time: 8:39 PM
 */

require_once( 'model/database.php' );

class user
{
    public $id = null;
    public $name = null;
    public $email = null;
    public $imagePath = null;

    public function __construct( $userArray ){

        $this->id = $userArray['id'];
        $this->email = $userArray['email'];
        $this->name = $userArray['name'];
        if( isset( $userArray['user_image'] ) && $userArray['user_image'] !== null ){
            $this->imagePath = $userArray['user_image'];
        }

    }
}