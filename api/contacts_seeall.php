<?php

    require __DIR__ . "/bootstrap.php";

    $userId = require_login();


    $pdo = db();
    $stmt = $pdo->prepare(
        "SELECT *
        FROM Contacts
        WHERE UserID = :uid
        LIMIT 50"
    );

    $stmt->execute([":uid" => $userId]);


    json_out(["results" => $stmt->fetchAll()]);

?>