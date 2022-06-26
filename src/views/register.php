<?php

$parent_layout = "not_authenticated";
function init($data, $url_params)
{ ?>

    <div>

        <h2 class="text-center">Register</h2>
        <form class="form" method="post">
            <label>
                Username:
                <input type="text" name="username" required>
            </label>
            <label>
                Email:
                <input type="email" name="email" required>
            </label>
            <label>
                Password:
                <input type="password" name="password" required>
            </label>
            <label>
                Repeat Password:
                <input type="password" name="password_repeat" required>
            </label>
            <?php
            if ($data["error"]) {
                if ($data["error"] === 'password_not_matching') {
                    $error = "Passwords didn't match, try again.";
                }
                ?>
                <p class="warning"><?= $error ?></p>
                <?php
            }
            ?>
            <input type="submit" value="Register">
        </form>
    </div>


<?php
} ?>
