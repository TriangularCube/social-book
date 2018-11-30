<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 12:51 AM
 */

require_once( 'model/userImagePath.php' );
require_once( 'model/userFunctions.php' );

if( isset( $displayFriendship) && $displayFriendship == true ){
    $isFriend = fetchIfFriendshipExist( $database, $viewingUser, $user );
}
?>

<div class="tile is-parent is-2">
    <div class="tile is-child">

        <div class="box">
            <figure class="img is-128x128">
                <img src="<?php echo $userImagePath ?>">
            </figure>

            <h5 class="subtitle has-text-centered"><a class="has-text-info" href=".?action=view_account&user=<?php echo $pathUser->id; ?>"><?php echo $pathUser->name ?></a></h5>
            <?php if( isset( $isFriend ) ): ?>
            <a class="button is-fullwidth <?php echo $isFriend == true ? "is-info" : ""; ?>" id="friend-button"><?php echo $isFriend == true ? "Friend" : "Become Friends"; ?></a>
            <?php endif; ?>
        </div>

        <div style="padding-top: 1rem">
            <aside class="menu box">
                <ul class="menu-list">
                    <li><a href=".">Timeline</a></li>
                    <li><a href=".?action=search">Search</a></li>
                    <li><a href=".?action=settings">Settings</a></li>
                </ul>
            </aside>
        </div>

        <?php if( isset( $isFriend ) && $isFriend === true): ?>
        <form action="index.php" method="post" id="unfriend">
            <input type="hidden" name="action" value="unfriend">
            <input type="hidden" name="last-action" value="<?php echo $action; ?>">
            <input type="hidden" name="lastUser" value="<?php echo $viewingUser->id; ?>">
        </form>
        <?php elseif( isset( $isFriend ) && $isFriend === false ): ?>
        <form action="index.php" method="post" id="friend">
            <input type="hidden" name="action" value="become_friends">
            <input type="hidden" name="last-action" value="<?php echo $action; ?>">
            <input type="hidden" name="lastUser" value="<?php echo $viewingUser->id; ?>">
        </form>
        <?php endif; ?>
    </div>
</div>


<script>
    let button = document.getElementById( 'friend-button' );

    <?php if( isset( $isFriend ) && $isFriend === true): ?>
    button.addEventListener( 'mouseenter', () => {
        button.classList.remove( 'is-info' );
        button.classList.add( 'is-danger' );
        button.innerText = "Unfriend";
    } );

    button.addEventListener( 'mouseleave', () => {
        button.classList.remove( 'is-danger' );
        button.classList.add( 'is-info' );
        button.innerText = "Friend";
    });

    button.addEventListener( 'click', () => {
        document.getElementById( 'unfriend' ).submit();
    });
    <?php elseif( isset( $isFriend ) && $isFriend === false ): ?>
    button.addEventListener( 'click', () => {
        document.getElementById( 'friend' ).submit();
    });
    <?php endif; ?>
</script>
