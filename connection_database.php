<?php
$host = 'mysql';
$db = "dummy";

$user = "dummy";
$pass = "dummy";
try {
    $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
    exit;
}