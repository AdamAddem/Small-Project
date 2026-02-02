<?php
    require __DIR__ . "/bootstrap.php";


    $userId = require_login();
    $data = json_in();

    $q = trim((string)($data["q"] ?? ""));
    if ($q === "") json_out(["results" => []]);

    $term = "%" . $q . "%";

    $pdo = db();
    $stmt = $pdo->prepare(
        "SELECT ID, FirstName, LastName, Email, Phone
        FROM Contacts
        WHERE UserID = :uid
        AND (FirstName LIKE :t1 OR LastName LIKE :t2 OR Email LIKE :t3 OR Phone LIKE :t4)
        ORDER BY LastName, FirstName
        LIMIT 50"
    );

    $stmt->execute([":uid" => $userId, ":t1" => $term, ":t2" => $term, ":t3" => $term, ":t4" => $term]);

    json_out(["results" => $stmt->fetchAll()]);
?>