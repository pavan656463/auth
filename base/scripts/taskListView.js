$(document).ready(function () {
    $(".task-box").click(function () {
        var title = $(this).data("title");
        var description = $(this).data("description");
        var dateCreated = $(this).data("date-created");
        var assignee = $(this).data("assignee");
        var task_status = $(this).data("task-status");
        var taskId = $(this).data("task-id");

        // Custom HTML for the Swal.fire modal with a comment box
        var modalContent = '<div class="card">' +
            '<div class="card-body text-start">' +
            '<h5 class="card-title text-center">' + title + '</h5>' +
            '<p class="card-text"><strong>Description:</strong> ' + description + '</p>' +
            '<p class="card-text"><strong>Assignee:</strong> ' + assignee + '</p>' +
            '<p class="card-text"><strong>Date Created:</strong> ' + dateCreated + '</p>' +
            '<p class="card-text"><strong>Task Status:</strong> ' + task_status + '</p>' +
            '<div class="mt-3">' +
            '<label for="comment"  style : "padding-bottom:30px ; ">Add Comment:</label>' +
            '<textarea class="form-control " id="comment" name="comment" rows="3" style="padding-top: 10px;margin-top: 10-; margin-top: 10px;"></textarea>' +
            '</div>' +
            '</div>' +
            '<form method="post" action="base.php">' +
            '<input type="hidden" name="done-task-id" value="' + taskId + '">' +
            '<button class="btn btn-primary btn-sm edit-task">Task Completed 👍</button>' +
            '</form>' +
            '</div>';

        Swal.fire({
            html: modalContent,
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonText: 'Close',
            customClass: {
                container: 'swal-modal-container-custom' // Add a custom class to the modal container
            }
        });
    });
});


$(document).ready(function () {
    $(".task-box-list").click(function () {
        var title = $(this).data("title");
        var description = $(this).data("description");
        var dateCreated = $(this).data("date-created");
        var assignee = $(this).data("assignee");
        var task_status = $(this).data("task-status");
        var taskId = $(this).data("task-id");

        Swal.fire({
            title: title,
            html: '<p>Description: ' + description + '</p><p>Assignee: ' + assignee + '</p><p>Date Created: ' + dateCreated + '</p><p>Task status: ' + task_status + '</p>',
            icon: 'info',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: 'OK',
        });
    });
});

