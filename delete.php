<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  exit();
}

if (!array_key_exists('id', $_POST)) {
  exit();
}

require_once('./pdo_connect.php');
require_once('./functions.php');

$id = h($_POST['id']);

$sql = 'DELETE FROM tasks WHERE id = :id';

$prepare = $dbh->prepare($sql);
$prepare->bindValue(':id', $id, PDO::PARAM_INT);

$result = $prepare->execute();

// response
header("Access-Control-Allow-Origin: *");
echo json_encode(['message' => 'success']);