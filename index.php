<?php

require_once('./functions.php');
require_once('./pdo_connect.php');
require_once('./task_status.php');

function findByStatus($status, $dbh) {
  $sql = 'SELECT * FROM tasks WHERE status = :status';
  $prepare = $dbh->prepare($sql);
  $prepare->bindValue(':status', $status, PDO::PARAM_INT);
  $prepare->execute();
  $todos = $prepare->fetchAll();

  return $todos;
}

$todos = findByStatus(TODO, $dbh);
$doings = findByStatus(DOING, $dbh);
$reviews = findByStatus(REVIEW, $dbh);
$dones = findByStatus(DONE, $dbh);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>
  <script src="assets/js/app.js" defer></script>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/reset.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/modal.css">

  <title>NexSeed-Task</title>
</head>
<body>

  <div class="container">

    <header class="header">
      <i class="fas fa-tasks header-icon"></i>
      <h1 class="header-title">NexSeed-Task</h1>
    </header>

    <main class="kanban-container">

      <div id="todo" class="kanban">
        <h4 class="kanban-title">Todo<i class="fas fa-plus-circle add-task-btn"></i></h4>

        <ul id="todo-container" class="task-container" data-status="<?= TODO ?>">
          <?php foreach($todos as $todo): ?>
            <li class="task" data-id="<?= $todo['id']; ?>" ><?= $todo['name']; ?></li>
          <?php endforeach; ?>
        </ul>

      </div>

      <div id="doing" class="kanban">
        <h4 class="kanban-title">Doing</h4>

        <ul id="doing-container" class="task-container" data-status="<?= DOING ?>">
          <?php foreach($doings as $todo): ?>
            <li class="task" data-id="<?= $todo['id']; ?>" ><?= $todo['name']; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div id="review" class="kanban">
        <h4 class="kanban-title">Review</h4>

        <ul id="review-container" class="task-container" data-status="<?= REVIEW ?>">
          <?php foreach($reviews as $todo): ?>
            <li class="task" data-id="<?= $todo['id']; ?>" ><?= $todo['name']; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div id="done" class="kanban">
        <h4 class="kanban-title">Done</h4>

        <ul id="done-container" class="task-container" data-status="<?= DONE ?>">
          <?php foreach($dones as $todo): ?>
            <li class="task" data-id="<?= $todo['id']; ?>" ><?= $todo['name']; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

    </main>

  </div>

</body>
</html>