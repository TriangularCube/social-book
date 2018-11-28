<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 12:49 AM
 */

$term = filter_input( INPUT_GET, "term" );

if( $term !== null && strlen( $term ) > 0 ){
    $users = findUsers( $database, $term );
}

?>

<body>

<div class="container">
    <div class="tile is-ancestor" style="padding-top: 2rem">

        <?php include_once( 'view/fragments/leftBar.php' ); ?>

        <div class="tile is-parent">
            <div class="tile is-child">

                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input type="text" class="input" id="searchBox">
                    </div>
                    <div class="control">
                        <button class="button is-info" id="searchButton">Search</button>
                    </div>
                </div>

                <br>

                <?php
                    if( count( $users ) > 0 ){
                        foreach( $users as $user ):
                            $userImagePath = $user->imagePath == null ? DEFAULT_IMAGE_PATH : $user->imagePath; ?>

                <div class="media box">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <img src=<?php echo $userImagePath ?>>
                        </p>
                    </figure>
                    <div class="media-content">
                        <h4 class="subtitle"><?php echo $user->name; ?></h4>
                    </div>
                </div>

                <?php endforeach; } ?>

            </div>
        </div>

    </div>
</div>

<script>

document.getElementById('searchButton').addEventListener( 'click', () => {
    let inputString = document.getElementById( 'searchBox' ).value;

    if( inputString.length > 0 ){
        window.location.href = '.?action=search&term=' + inputString;
    }

});

</script>

</body>
