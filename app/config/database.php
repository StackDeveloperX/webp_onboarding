<?php
// app/config/database.php

$host    = '103.20.200.177';
$db      = 'webpstco_onboarding_new';
$user    = 'webpstco_onboarding_new';      // change if needed
$pass    = 'jI@sxU]eXTuUDRiLY#';          // change if needed
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>