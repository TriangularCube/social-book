<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/25/2018
 * Time: 2:59 AM
 */

require_once( 'userFetch.php' );
require_once( 'user.php' );
require_once( 'post.php' );

function createUser( $db, $name, $email, $password, $confirmPassword ){

    // Validate some stuff
    if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) || !checkEmailRegistered( $db, $email ) ){
        return false;
    }

    if( strlen( $password ) < 8 || $confirmPassword != $password ){
        return false;
    }

    $passHash = password_hash( $password, PASSWORD_DEFAULT );

    $query = 'INSERT INTO `users`
                ( name, email, password )
              VALUES 
                ( :name, :email, :password )';

    $stmt = $db->prepare( $query );

    $stmt->bindValue( ':name', $name );
    $stmt->bindValue( ':email', $email );
    $stmt->bindValue( ':password', $passHash );

    $stmt->execute();
    $stmt->closeCursor();

    //getUserByEmail( $db, $email, $password );

    return true;

}

function checkEmailRegistered($db, $email ){
    $query = "SELECT email FROM users WHERE email = :email";

    $stmt = $db->prepare($query);

    $stmt->bindValue(  ':email', $email );

    $stmt-> execute();

    $list = $stmt->fetchAll();
    $stmt->closeCursor();

    if( count( $list ) == 0 ){
        return true;
    }

    return false;
}

function getUserByEmail( $db, $email, $password ){

    $result = fetchUser( $db, $email );

    if( $result->success === false ){
        return $result;
    }

    //TODO
    $hash = $result->user['password'];

    $logResult = password_verify( $password, $hash );

    if( $logResult === false ){
        $result->success = false;
        $result->error = FETCH_PASSWORD_MISMATCH;
        $result->user = null;

        return $result;
    }

    $result->success = true;
    $result->error = null;

    $user = new user( $result->user );

    $result->user = $user;

    return $result;

}

function fetchUser( $db, $email ){
    $query = 'SELECT * FROM users
              WHERE email = :email';

    $stmt = $db->prepare( $query );

    $stmt->bindValue( ':email', $email );

    $stmt->execute();

    $resultUsers = $stmt->fetchAll();
    $stmt->closeCursor();

    $fetch = new userFetch();

    if( count( $resultUsers ) < 1 ){
        $fetch->success = false;
        $fetch->error = FETCH_NO_USER;
    } else if ( count ( $resultUsers ) > 1 ){
        $fetch->success = false;
        $fetch->error = FETCH_MORE_THAN_ONE_USER;
    } else {
        $fetch->success = true;
        $fetch->user = $resultUsers[0];
    }

    return $fetch;
}

function fetchUserByID( $db, $id ){

    $query = 'SELECT * FROM users WHERE id = :id';

    $stmt = $db->prepare( $query );

    $stmt->bindValue( ':id', $id );
    $stmt->execute();

    $user = $stmt->fetch();

    $stmt->closeCursor();

    $user = new user( $user );

    return $user;

}

function postTo( $db, $userFromID, $userToID, $content ){

    $query = 'INSERT INTO posts
                ( user_from, user_to, content, time )
              VALUES
                ( :user_from, :user_to, :content, NOW() )';

    $stmt = $db->prepare( $query );

    $stmt->bindValue( ":user_from", $userFromID );
    $stmt->bindValue( ":user_to", $userToID );
    $stmt->bindValue( ":content", $content );

    $stmt->execute();
    $stmt->closeCursor();

}

function findUsers( $db, $term ){

    $query = 'SELECT * FROM users WHERE name LIKE :term';

    $stmt = $db->prepare($query);

    $stmt->bindValue( ':term', '%'.$term.'%' );
    $stmt->execute();

    $results = $stmt->fetchAll();
    $stmt->closeCursor();

    $users = array();

    foreach( $results as $user ){
        $users[] = new user( $user );
    }

    return $users;

}

function fetchPostsFor( $db, $userID ){

    $query = 'SELECT * FROM posts WHERE user_to = :user';

    $stmt = $db->prepare($query);
    $stmt->bindValue( ':user', $userID );

    $stmt->execute();

    $results = $stmt->fetchAll();

    $stmt->closeCursor();

    $posts = array();

    foreach( $results as $result ){
        $posts[] = new post( $result, null );
    }

    return $posts;

}