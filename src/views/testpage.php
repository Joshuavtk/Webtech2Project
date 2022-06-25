<?php function init($data, $url_params) { ?>

    <div>
        <style>
            :root {
                color-scheme: dark light;
            }
        </style>

        <h3>
            Homepage
        </h3>
        <p>Hello <?= $data["name"] ?></p>

        <h2>Users</h2>
        <?php
        foreach ($data["users"] as $user) {

            ?>
            <p>User: <?= $user[0] ?></p>
            <?php
        }
        ?>
    </div>


<?php } ?>
