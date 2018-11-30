<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/26/2018
 * Time: 3:31 PM
 */

require_once( 'model/userFunctions.php' );

$pathUser = $user;
$results = fetchPostsForTimeline( $database, $user->id );

?>

<body>

<div class="container">
    <div class="tile is-ancestor" style="padding-top: 2rem; padding-bottom: 2rem">

        <?php include( 'view/fragments/leftBar.php' ); ?>

        <div class="tile is-parent">
            <div class="tile is-child">

                <?php include( 'view/fragments/sharePost.php' ); ?>

                <!-- Divider? -->
                <br>

                <!-- Posts -->
                <?php
                    foreach( $results as $result ){
                        $post = new post( $result, null );
                        $pathUser = fetchUserByID( $database, $post->fromUserID );

                        include( 'model/userImagePath.php' );

                        $fromUser = fetchUserByID( $database, $post->fromUserID );
                        $toUser = fetchUserByID( $database, $post->toUserID );
                        include( 'view/fragments/postView.php' );
                } ?>

            </div>
        </div>

    </div>
</div>

</body>
