<?php
// Database
include_once( 'model/database.php' );
include_once( 'model/userFunctions.php' );

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

include_once( 'view/header.html' );
if( isset( $_SESSION['user'] ) ){
    // Only include navbar if logged in
    include_once( 'view/navbar.php' );
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
        $user = $_SESSION['user'];

        include( 'view/viewTimeline.php' );

        // TODO View account timeline
        break;
    case 'logout':
        unset( $_SESSION['user'] );
        header( 'Location: .' );
        break;
}

// Footer
include_once( 'view/footer.html' );