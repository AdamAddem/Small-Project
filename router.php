<?php
// router.php - maps /api/login -> api/login.php etc. for php -S

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Serve static files if they exist
$publicFile = __DIR__ . "/public" . $path;
if ($path !== "/" && file_exists($publicFile) && !is_dir($publicFile)) {
    return false;
}

// API routes
$routes = [
    "/api/login" => __DIR__ . "/api/login.php",
    "/api/register" => __DIR__ . "/api/register.php",
    "/api/logout" => __DIR__ . "/api/logout.php",

    "/api/contacts/search" => __DIR__ . "/api/contacts_search.php",
    "/api/contacts/create" => __DIR__ . "/api/contacts_create.php",
    "/api/contacts/update" => __DIR__ . "/api/contacts_update.php",
    "/api/contacts/delete" => __DIR__ . "/api/contacts_delete.php",
    "/api/contacts/seeall" => __DIR__ . "/api/contacts_seeall.php",
];

if (isset($routes[$path])) {
    require $routes[$path];
    exit;
}

// Default: serve the SPA/HTML entry
require __DIR__ . "/public/index.html";
?>