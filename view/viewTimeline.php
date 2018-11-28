<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/26/2018
 * Time: 3:31 PM
 */

$userImagePath = 'sb_images/generic-profile.jpg';

if( $user->imagePath !== null ){
    $userImagePath = $user->imagePath;
}
?>

<body>

<div class="container">
    <div class="tile is-ancestor" style="padding-top: 2rem">

        <div class="tile is-parent is-2">
            <div class="tile is-child">

                <div class="box">
                    <figure class="img is-128x128">
                        <img src="<?php echo $userImagePath ?>">
                    </figure>

                    <h5 class="subtitle has-text-centered"><?php echo $user->name ?></h5>
                </div>

                <div style="padding-top: 1rem">
                    <aside class="menu box">
                        <ul class="menu-list">
                            <li><a>Timeline</a></li>
                            <li><a>Search</a></li>
                        </ul>
                    </aside>
                </div>

            </div>
        </div>

        <div class="tile is-parent">
            <div class="tile is-child">

                <article class="media box">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <img src=<?php echo $userImagePath ?>>
                        </p>
                    </figure>
                    <div class="media-content">
                        Lorem ipsum
                    </div>
                </article>

            </div>
        </div>

    </div>
</div>

</body>
