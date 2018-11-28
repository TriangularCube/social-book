<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/21/2018
 * Time: 8:05 PM
 */

require_once( 'model/userFunctions.php' );

$userID = filter_input( INPUT_GET, 'user' );

if( $userID === null || strlen( $userID ) < 1 ){
    header( 'Location: .' );
}

$viewingUser = fetchUserByID( $database, $userID );
$posts = fetchPostsFor( $database, $viewingUser->id );

?>

<body>

<div class="container">

    <div class="tile is-ancestor" style="padding-top: 2rem">

        <?php include( 'view/fragments/leftBar.php' ); ?>

        <div class="tile is-parent">
            <div class="tile is-child">

                <?php include( 'view/fragments/sharePost.php' ); ?>
                <!-- TODO Still need to take into account which page we loaded so we hit the right page on submit -->

                <!-- Divider? -->
                <br>

                <!-- Posts -->
                <!-- TODO Fetch posts -->
                <?php
                    foreach( $posts as $post ){
                        $pathUser = fetchUserByID( $database, $post->toUserID );
                        include( 'model/userImagePath.php' );
                        include( 'view/fragments/postView.php' );
                    }
                ?>
            </div>
        </div>

    </div>

</div>

</body>