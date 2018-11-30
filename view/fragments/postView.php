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
            $displayFrom = $fromUser->name;
            $displayTo = $toUser->name;
        ?>
        <h4>
            <?php if( $fromUser->id !== $toUser->id ): ?>
            <a class="has-text-info" href=".?action=view_account&user=<?php echo $fromUser->id; ?>"><?php echo $displayFrom; ?></a>
                <i class="fas fa-arrow-right"></i>
            <?php endif; ?>
            <a class="has-text-info" href=".?action=view_account&user=<?php echo $toUser->id; ?>"><?php echo $displayTo; ?></a>
        </h4>
        <h6 class="has-text-dark is-small"><?php echo $post->time; ?></h6>

        <p class="content" style="padding-top: .4rem">
            <?php echo $post->content; ?>
        </p>
    </div>
</div>
