const Task = ({ task }) => `
  <li class="task">${task}</li>
`;

const InputTask = () => `
  <li class="task">
    <input id="new-task" type="text" class="new-task-name">
    <button class="add-btn">ADD</button>
  </li>
`;

$(document).on('click', '.add-task-btn', () => {
  $('#todo .task-container').prepend(InputTask());
});

$(document).on('contextmenu', '.task', (event) => {
  if (window.confirm("Do you really want to delete task ?")) {

    const id = $(event.target).data('id');
    $.ajax({
      type: "POST",
      url: "./delete.php",
      data: {
        id: id
      },
      dataType: "json",
    }).done(data => {
      $(event.target).remove();
    }).fail(error => {
      console.log(error);
      alert('Error');
    })
  }
  return false;
})

$(document).on('click', '.add-btn', () => {

  let newTask = $('#new-task').val();

  if (newTask == '') {
    alert('Task is Empty');
    return;
  }

  $.ajax({
    type: "POST",
    url: "./create.php",
    data: {
      name: newTask
    },
    dataType: "json",
  }).done(data => {
    $('#todo .task-container').prepend(Task({ task: newTask }));
    $('#new-task').parent().remove();
  }).fail(error => {
    console.log(error);
    alert('Error');
  })

});

$('li', $('.task-container')).draggable({
  revert: "invalid", // when not dropped, the item will revert back to its initial position
  containment: "document",
  helper: "clone",
  cursor: "move"
});

$('.task-container').droppable({
  accept: ".task-container > li",
  drop: function (event, ui) {
    moveTask(ui.draggable, $(this));
  }
});

function moveTask($item, $parent) {
  const status = $parent.data('status');
  const id = $item.data('id');

  $.ajax({
    type: "POST",
    url: "./update.php",
    data: {
      id: id,
      status: status
    },
    dataType: "json",
  }).done(data => {
    $item.appendTo($parent);
  }).fail(error => {
    console.log(error);
    alert('Error');
  })

}