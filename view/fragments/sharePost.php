<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 3:09 AM
 */

$pathUser = $user;
require( 'model/userImagePath.php' ); // CANNOT REQUIRE_ONCE HERE, idiot
if( $action == 'view_account' ){
    require_once( 'model/getViewingAccountUser.php' );
}
?>

<!-- Share Post -->
<article class="media box">
    <figure class="media-left">
        <p class="image is-64x64">
            <img src=<?php echo $userImagePath; ?>>
        </p>
    </figure>
    <div class="media-content">
        <form action="index.php" method="post" id="share-post">
            <input type="hidden" name="action" value="share-post">

            <!-- If we're posting from viewing_account, then give the posting id. Otherwise give the current user id -->
            <input type="hidden" name="post-to" value=<?php echo isset( $viewingUser ) ? $viewingUser->id : $user->id; ?>>

            <input type="hidden" name="last-action" value="<?php echo $action; ?>">
            <?php
                switch( $action ){
                    case 'view_account':
            ?>
            <input type="hidden" name="last-user" value=<?php echo $viewingUser->id ?>>
            <?php
                        break;
                }
            ?>
            <div class="content">
                <textarea class="textarea" placeholder="Share Something..." name="post-text" id="post-text"></textarea>
            </div>
            <nav class="level is-mobile">
                <div class="level-right">
                    <a class="level-item">
                        <!--<span class="icon is-medium"><i class="fas fa-heart"></i></span>-->
                        <input type="submit" class="button is-info" id="submitButton" disabled>
                    </a>
                </div>
            </nav>
        </form>
    </div>
</article>

<script>
    let submitButton = document.getElementById( 'submitButton' );
    let postTextArea = document.getElementById( 'post-text' );

    postTextArea.addEventListener( "input", () => {
        let postString = postTextArea.value;

        if( postString.length > 0 ){
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    });
</script>