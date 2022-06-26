<?php
function init($data, $url_params)
{ ?>

    <div>
        <h3>
            Dashboard
        </h3>

        <div class="coins">

            <?php
            foreach ($data["data"] as $coin_data) {
                ?>
                <div class="coin">

                    <p>Slug: <?= $coin_data["slug"] ?></p>
                    <p>Symbol: <?= $coin_data["symbol"] ?></p>
                    <p>Price (USD): $<?= $coin_data["metrics"]["market_data"]["price_usd"] ?></p>
                    <p><a href="./coin?coin=<?= $coin_data["slug"] ?>">Trade coin</a></p>

                </div>
                <?php
            }
            ?>
        </div>
    </div>


<?php
} ?>
