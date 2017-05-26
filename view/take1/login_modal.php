<!-- The Modal -->
<div id="modal" class="modal">

    <span id="close_modal" class="close" title="Close Modal">&times;</span>

    <!-- Modal Content -->

        <div class="modal-content animate">
            <div class="container" id='login-container'>
                <form class="container" action="<?= $app->url->create('login') ?>" method="POST">

                    <p><b>Username</b></p>
                    <input type="text" placeholder="Enter Username" name="uname" required>

                    <p><b>Password</b></p>
                    <input type="password" placeholder="Enter Password" name="psw" required>

                    <button type="submit">Login</button>

                </form>
            </div>

            <p id='reg-text'>
                Or <a id="register" class="register_activator">register&nbsp;&darr;</a>
            </p>

            <div class="container container-register" id="container-register">

                <form class="form_register container" action="<?= $app->url->create('register') ?>" method="post">
                    <p><b>Username</b></p>
                    <input type="text" placeholder="Enter Username" name="uname" required>

                    <p><b>Password</b></p>
                    <input type="password" placeholder="Enter Password" name="psw" required>

                    <input type="password" placeholder="Repeat Password" name="pswrepeat" required>

                    <p>
                        Admin?
                        <input type="checkbox" name="admin">
                    </p>

                    <button type="submit">Register</button>
                </form>

            </div>
    </div>

</div>
