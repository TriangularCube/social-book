<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/21/2018
 * Time: 8:47 PM
 */

switch( $action ){
    case 'view_timeline':
        $mode = "Timeline";
        break;
    case 'search':
        $mode = "Search";
        break;
    case 'view_account':
        require_once( 'model/getViewingAccountUser.php' );
        $mode = $viewingUser->name;
        break;
    default:
        $mode = "";
}
?>
<nav class="navbar is-primary is-fixed_top" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="index.php">
                <img src="sb_images/logo.png" width="40" height="60">
            </a>
            <h4 class="navbar-item subtitle"><?php echo $mode; ?></h4>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <div class="control navbar-item">
                    <a href="index.php?action=logout" class="button is-info" value="Logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>