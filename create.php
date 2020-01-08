<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  exit();
}

if (!array_key_exists('name', $_POST)) {
  exit();
}

require_once('./pdo_connect.php');
require_once('./functions.php');
require_once('./task_status.php');

$name = h($_POST['name']);

$sql = 'INSERT INTO tasks(name, status, created_at, updated_at) VALUES (:name, :status, now(), now())';

$prepare = $dbh->prepare($sql);
$prepare->bindValue(':name', $name, PDO::PARAM_STR);
$prepare->bindValue(':status', TODO, PDO::PARAM_INT);

$result = $prepare->execute();

$lastInsertId = $dbh->lastInsertId();

// response
header("Access-Control-Allow-Origin: *");
echo json_encode(['id' => $lastInsertId]);