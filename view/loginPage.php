<?php
/**
 * Created by PhpStorm.
 * User: Maelstrom Forge
 * Date: 11/26/2018
 * Time: 1:46 PM
 */
require_once( 'model/userFetch.php' );
?>

<body>
<div class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h1 class="title"><strong>Social Book (A class project)</strong></h1>
                    </div>
                </div>

            </nav>
        </div>
    </div>
</div>

<section class="section">
    <article class="container">
        <div class="tile is-ancestor">
            <div class="tile is-parent">
                <div class="tile is-8 is-child box">
                    <h1 class="title"><strong>Login</strong></h1>
                    <form action="." method="post" id="login">
                        <input type="hidden" name="action" value="login">

                        <!-- Email Address -->
                        <div class="field">
                            <p class="control has-icons-left has-icons-right">
                                <input class="input" type="text" placeholder="Email Address" name="email_login">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </p>
                        </div>

                        <!-- Password -->
                        <div class="field">
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" type="password" placeholder="Password" name="password_login">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="field">
                            <p class="control">
                                <button class="button is-primary is-linked" type="submit">
                                    Login
                                </button>
                            </p>
                        </div>
                        <?php
                        if( $error == FETCH_NO_USER || $error == FETCH_PASSWORD_MISMATCH ):?>
                            <p class="help is-danger" id="login_helper">No account associated with that email, or the password is incorrect</p>
                        <?php endif ?>
                    </form>
                </div>
            </div>


            <div class="tile is-parent">
                <div class="tile is-8 is-child box">
                    <h1 class="title"><strong>Create a New Account</strong></h1>
                    <form action="index.php" method="post" id="create_account">
                        <input type="hidden" name="action" value="create_account">

                        <!-- Name -->
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="Name" name="name" id="name">
                                <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="field">
                            <p class="control has-icons-left has-icons-right" id="email_input_p">
                                <input class="input" type="text" placeholder="Email Address" name="email" id="email">
                                <span class="icon is-small is-left">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                            </p>
                            <p class="help is-danger" style="visibility: hidden" id="email_helper">That email is already
                                taken</p>
                        </div>

                        <!-- Password -->
                        <div class="field">
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" type="password" placeholder="Password" name="password"
                                       id="password">
                                <span class="icon is-small is-left">
                                        <i class="fas fa-lock"></i>
                                    </span>
                            </div>
                        </div>

                        <!-- Verify Password -->
                        <div class="field">
                            <p class="control has-icons-left has-icons-right">
                                <input class="input" type="password" placeholder="Confirm Password"
                                       name="confirm_password" id="confirm_password">
                                <span class="icon is-small is-left">
                                        <i class="fas fa-lock"></i>
                                    </span>
                            </p>
                            <p class="help is-danger" style="visibility: hidden" id="password_helper">Password does not
                                match</p>
                        </div>

                        <!-- Submit -->
                        <div class="field">
                            <p class="control">
                                <button class="button is-primary is-linked" type="submit">
                                    Create Account
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article>

    <script src="javascript/creatAccount.js"></script>

</section>
</body>