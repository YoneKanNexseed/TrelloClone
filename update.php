<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  exit();
}

if (!array_key_exists('id', $_POST) || !array_key_exists('status', $_POST)) {
  exit();
}

require_once('./pdo_connect.php');
require_once('./functions.php');

$id = h($_POST['id']);
$status = h($_POST['status']);

$sql = 'UPDATE tasks SET status = :status, updated_at = now() WHERE id = :id';

$prepare = $dbh->prepare($sql);
$prepare->bindValue(':status', $status, PDO::PARAM_INT);
$prepare->bindValue(':id', $id, PDO::PARAM_INT);

$result = $prepare->execute();

// response
header("Access-Control-Allow-Origin: *");
echo json_encode(['message' => 'success']);