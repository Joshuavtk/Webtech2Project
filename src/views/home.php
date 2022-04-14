<?php
$data = [];
function init($params) {
    $data = $params;
    ?>
<div>

    <h3>
        Homepage
    </h3>
    <p>Hello <?= $data["name"] ?></p>

</div>


<?php
}
?>
