<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/21/2018
 * Time: 8:05 PM
 */

require_once( 'model/getViewingAccountUser.php' );
$pathUser = $viewingUser;

$displayFriendship = $viewingUser->id !== $user->id;
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
                    foreach( $posts as $post ){
                        $pathUser = fetchUserByID( $database, $post->fromUserID );

                        $fromUser = fetchUserByID( $database, $post->fromUserID );
                        $toUser = fetchUserByID( $database, $post->toUserID );
                        include( 'model/userImagePath.php' );
                        include( 'view/fragments/postView.php' );
                    }
                ?>
            </div>
        </div>

    </div>

</div>

</body>