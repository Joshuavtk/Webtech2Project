<?php function init($data, $url_params){ ?>

    <div>
        <h3>
            404 - Page not found!
        </h3>
        <p>We couldn't find a page with the url "<?= $url_params["path"] ?>"</p>
        <p><a href="./">Go back to home</a> </p>
    </div>

<?php } ?>