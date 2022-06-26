<?php

$parent_layout = "not_authenticated";
function init($data, $url_params)
{ ?>

    <div>

        <h2 class="text-center">Login</h2>
        <form class="form" method="post">
            <label>
                Email:
                <input type="email" name="email" required>
            </label>
            <label>
                Password:
                <input type="password" name="password" required>
            </label>
            <?php
            if ($data["error"]) {
                if ($data["error"] === 'incorrect_data') {
                    $error = "Incorrect login data, try again.";
                }
                ?>
                <p class="warning"><?= $error ?></p>
                <?php
            }
            ?>
            <input type="submit" value="Login">
        </form>
    </div>


    <?php
} ?>
