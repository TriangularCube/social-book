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
        <h4 class="has-text-info">Name</h4>

        <p class="content" style="padding-top: .4rem">
            <?php echo $post->content; ?>
        </p>
    </div>
</div>
