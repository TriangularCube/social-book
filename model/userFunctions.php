<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/25/2018
 * Time: 2:59 AM
 */

require_once( 'model/constants.php' );
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

    $user = $result->user;

    if( isset( $user['user_image'] ) && $user['user_image'] !== null ){
        $query = 'SELECT path FROM images WHERE id = :id';
        $stmt = $db->prepare( $query );
        $stmt->bindValue( ':id', $user['user_image'] );
        $stmt->execute();

        $path = $stmt->fetch()['path'];

        $stmt->closeCursor();

        $user['user_image'] = $path;
    }

    $user = new user( $user );

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

    if( isset( $user['user_image'] ) && $user['user_image'] !== null ){
        $query = 'SELECT path FROM images WHERE id = :id';
        $stmt = $db->prepare( $query );
        $stmt->bindValue( ':id', $user['user_image'] );
        $stmt->execute();

        $path = $stmt->fetch()['path'];

        $user['user_image'] = $path;
    }

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
        if( isset( $user['user_image'] ) && $user['user_image'] !== null ){
            $query = 'SELECT path FROM images WHERE id = :id';
            $stmt = $db->prepare( $query );
            $stmt->bindValue( ':id', $user['user_image'] );
            $stmt->execute();

            $path = $stmt->fetch()['path'];

            $user['user_image'] = $path;
        }

        $users[] = new user( $user );
    }

    return $users;

}

function fetchPostsForAccount($db, $userID ){

    $query = 'SELECT * FROM posts WHERE user_to = :user OR user_from = :user ORDER BY time DESC';

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

function fetchIfFriendshipExist( $db, $user1, $user2 ){

    $query = 'SELECT DISTINCT f.* FROM friendships f JOIN users u
                ON
              user_1 = u.id OR user_2 = u.id
                WHERE
              (user_1 = :user1 AND user_2 = :user2) OR (user_1 = :user2 AND user_2 = :user1)';

    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':user1', $user1->id );
    $stmt->bindValue( ':user2', $user2->id );
    $stmt->execute();

    $result = $stmt->fetch();

    $stmt->closeCursor();

    return $result !== false;

}

function becomeFriends( $db, $user1ID, $user2ID ){

    $query = 'INSERT INTO friendships
                (user_1, user_2)
              VALUES
                (:user1, :user2)';

    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':user1', $user1ID );
    $stmt->bindValue( ':user2', $user2ID );

    $stmt->execute();
    $stmt->closeCursor();

}

function removeFriendship( $db, $user1ID, $user2ID ){

    $query = 'DELETE FROM friendships WHERE
              (user_1 = :user1 AND user_2 = :user2) OR (user_1 = :user2 AND user_2 = :user1)';

    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':user1', $user1ID );
    $stmt->bindValue( ':user2', $user2ID );

    $stmt->execute();
    $stmt->closeCursor();


}

function fetchPostsForTimeline( $db, $userID ){

    $query = 'SELECT DISTINCT p.* FROM (
                SELECT u.* FROM users u JOIN friendships f ON (f.user_1 = u.id OR f.user_2 = u.id)
                WHERE (f.user_1 = :user OR f.user_2 = :user)
                UNION
                SELECT * FROM users WHERE id = :user
              ) AS u JOIN posts p ON (u.id = p.user_from OR u.id = p.user_to)
              ORDER BY time DESC';

    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':user', $userID );
    $stmt->execute();

    $results = $stmt->fetchAll();

    return $results;

}

function updateUserImage( $db, $userID, $path ){

    $query = 'INSERT INTO images
                ( path, user_id )
              VALUES
                ( :path, :user )';

    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':path', $path );
    $stmt->bindValue( ':user', $userID );
    $stmt->execute();

    $query = 'SELECT id FROM images WHERE path = :path';
    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':path', $path );
    $stmt->execute();

    $id = $stmt->fetch()['id'];

    $query = 'UPDATE users SET user_image = :id WHERE id = :user';

    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':id', $id );
    $stmt->bindValue( ':user', $userID );

    $stmt->execute();
    $stmt->closeCursor();

}

function getImagePath( $db, $imgID ){

    $query = 'SELECT path FROM images WHERE id = :id';
    $stmt = $db->prepare( $query );
    $stmt->bindValue( ':id', $imgID );
    $stmt->execute();

    $path = $stmt->fetch()['path'];

    $stmt->closeCursor();

    return $path;

}