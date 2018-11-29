<?php
// Database
require_once( 'model/database.php' );
require_once( 'model/userFunctions.php' );

// Start session management with a persistent cookie
$lifetime = 60 * 60 * 24 * 14;    // 2 weeks in seconds
session_set_cookie_params($lifetime, '/');
session_start();

// Get action
$action = filter_input( INPUT_POST, 'action' );
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'view_front_page';
    }
}

// If action is view front page and we're logged in, redirect to Timeline
if( $action == 'view_front_page' && isset( $_SESSION['user'] ) ){
    $action = 'view_timeline';
}

include_once('view/fragments/header.html');
if( isset( $_SESSION['user'] ) ){
    // Mode set in navbar.php

    // Only include navbar if logged in
    include_once('view/fragments/navbar.php');

    // Also pull the user out
    $user = $_SESSION['user'];
}


// Actions
switch ($action){
    case 'view_front_page':
        include( 'view/viewFrontPage.php' );
        break;
    case 'view_login_page':
        include( 'view/loginPage.php' );
        break;
    case 'create_account':
        $name = filter_input( INPUT_POST, 'name' );
        $email = filter_input( INPUT_POST, 'email' );
        $password = filter_input( INPUT_POST, 'password' );
        $confirmPassword = filter_input( INPUT_POST, 'confirm_password' );

        if( !createUser( $database, $name, $email, $password, $confirmPassword ) ){
            echo "User not created: " . $name . " : " . $email . " : " . $password;
        } else {
            $user = fetchUser($database, $email );
            $_SESSION['user'] = $user;
            header("Location: ." );
        }

        break;
    case 'login':
        $email = filter_input( INPUT_POST, 'email_login' );
        $password = filter_input( INPUT_POST, 'password_login' );

        $fetch = getUserByEmail( $database, $email, $password );

        if( $fetch->success === false ){
            $error = $fetch->error;
            include( 'view/loginPage.php' );
            break;
        }

        $_SESSION['user'] = $fetch->user;
        header( "Location: ." );

        break;
    case 'view_timeline':
        include( 'view/viewTimeline.php' );
        break;
    case 'search':
        include( 'view/search.php' );
        break;
    case 'view_account':
        include( 'view/viewAccount.php' );
        break;
    case 'share-post':
        $content = filter_input( INPUT_POST, "post-text" );
        $postTo = filter_input( INPUT_POST, 'post-to' );

        /* Last ditch sanity check */
        if( !isset(  $postTo ) ){
            $postTo = $user->id;
        }

        postTo( $database, $user->id,$postTo, $content );

        $lastAction = filter_input( INPUT_POST, 'last-action' );

        switch( $lastAction ){
            case 'view_account':
                // TODO
                $lastUserID = filter_input( INPUT_POST, 'last-user' );
                header( 'Location: .?action=view_account&user=' . $lastUserID );
                break;
            case 'view_timeline':
                header( 'Location: .' );
                break;
        }

        break;
    case 'logout':
        unset( $_SESSION['user'] );
        header( 'Location: .' );
        break;
}

// Footer
include_once('view/fragments/footer.html');