<?php

function init($data, $url_params)
{ ?>

    <div class="coin_info">
        <h3>
            <?= $data["coin"]["symbol"] ?> - <?= $data["coin"]["slug"] ?>
        </h3>

        <div class="data">
            <p>Price (USD): $<?= $data["coin"]["market_data"]["price_usd"] ?></p>

            <?php
            if (isset($data["owned"])) {
                ?>
                <p>You own <?= $data["owned"] ?> <?= $data["coin"]["symbol"] ?></p>

                <?php
            }
            ?>

            <form method="post" class="form">
                <h4>Buy <?= $data["coin"]["slug"] ?></h4>
                <input type="hidden" name="value" value="<?= $data["coin"]["market_data"]["price_usd"] ?>">
                <p>Money left (USD): $<?= $data["remaining_usd"] ?></p>
                <label>Amount of USD to buy coin with
                    <input type="number" name="amount" min="1" max="<?= $data["remaining_usd"] ?>" required>
                </label>
                <input type="submit" value="Buy coin">
            </form>
        </div>
    </div>


    <?php
} ?>
