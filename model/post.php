<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 3:18 AM
 */

class post{

    public $id;
    public $fromUserID;
    public $toUserID;
    public $content;
    public $images = null;

    function __construct( $post, $images ){
        $this->id = $post['id'];
        $this->fromUserID = $post['user_from'];
        $this->toUserID = $post['user_to'];
        $this->content = $post['content'];

        if( $images !== null ){
            $this->images = $images;
        }
    }

}