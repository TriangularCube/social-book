<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/28/2018
 * Time: 3:29 AM
 */
?>

<div class="media box">
    <figure class="media-left">
        <p class="image is-64x64">
            <img src="<?php echo $userImagePath ?>">
        </p>
    </figure>
    <div class="media-content">

        <!-- Deal with different posting types, and different name displays -->
        <?php
            // If the poster is the person we're seeing
            if( isset( $viewingUser ) ){
                if(  $viewingUser->id === $pathUser->id ){
                    $display = $viewingUser->name;
                } else {
                    $display = $pathUser->name . " -> " . $viewingUser->name;
                }
            } else {
                // TODO
                $display = "Name";
            }
        ?>
        <h4 class="has-text-info"><?php echo $display ?></h4>

        <p class="content" style="padding-top: .4rem">
            <?php echo $post->content; ?>
        </p>
    </div>
</div>
