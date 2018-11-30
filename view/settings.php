<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/30/2018
 * Time: 1:01 AM
 */

$pathUser = $user;

$error = filter_input( INPUT_GET, 'error' );
?>

<body>

<div class="container">

    <div class="tile is-ancestor" style="padding-top: 2rem; padding-bottom: 2rem">

        <?php include( 'view/fragments/leftBar.php' ); ?>

        <div class="tile is-parent">
            <div class="tile is-child">
                <?php if( isset( $error ) ): ?>
                <h4 class="subtitle has-text-danger">There was a problem with the image upload</h4>
                <?php endif; ?>

                <button class="button is-fullwidth" id="image-change">Change Profile Image</button>

            </div>
        </div>

    </div>

    <div class="modal" id="image-add">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="card">
                <form enctype="multipart/form-data" action="index.php" method="post">
                    <input type="hidden" name="action" value="upload_user_image" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">

                    <div class="level">
                        <div class="level-left">
                            <div class="file">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="image_upload" accept="image/*">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Choose a file…
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="level-right">
                            <input class="button" value="Upload" type="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close" id="close-modal"></button>
    </div>

</div>

<script>
    let image_button = document.getElementById( 'image-change' );
    let modal = document.getElementById( 'image-add' );
    let close_button = document.getElementById( 'close-modal' );

    image_button.addEventListener( 'click', () => {
        modal.classList.add( 'is-active' );
    });

    close_button.addEventListener( 'click', () => {
       modal.classList.remove( 'is-active' );
    });
</script>

</body>
