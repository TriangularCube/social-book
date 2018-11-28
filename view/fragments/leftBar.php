<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 12:51 AM
 */
require_once( 'model/userImagePath.php' );
?>

<div class="tile is-parent is-2">
    <div class="tile is-child">

        <div class="box">
            <figure class="img is-128x128">
                <img src="<?php echo $userImagePath ?>">
            </figure>

            <h5 class="subtitle has-text-centered"><?php echo $user->name ?></h5>
        </div>

        <div style="padding-top: 1rem">
            <aside class="menu box">
                <ul class="menu-list">
                    <li><a href=".">Timeline</a></li>
                    <li><a href=".?action=search">Search</a></li>
                </ul>
            </aside>
        </div>

    </div>
</div>
