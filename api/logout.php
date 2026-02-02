<?php
    require __DIR__ . "/bootstrap.php";

    session_destroy();
    json_out(["ok" => true]);
?>