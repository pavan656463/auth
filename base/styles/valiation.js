$(document).ready(function () {
    var formSubmitted = false; // Flag to track form submission

    $(".task-box").click(function () {
        var title = $(this).data("title");
        var description = $(this).data("description");
        var dateCreated = $(this).data("date-created");

        Swal.fire({
            title: title,
            html: '<p>Description: ' + description + '</p><p>Date Created: ' + dateCreated + '</p>',
            icon: 'info',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: 'OK',
        });
    });

    // AJAX form submission
    $("addTaskForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        if (formSubmitted) {
            // If form has already been submitted, do nothing
            return;
        }

        // Validate title and assignee
        var title = $("#title").val().trim();
        var assignee = $("#assignee").val().trim();

        if (title === "" || assignee === "") {
            // Show an alert if title or assignee is empty
            Swal.fire({
                title: 'Validation Error',
                text: 'Title and Assignee cannot be empty',
                icon: 'error',
                confirmButtonText: 'OK',
            });
            return;
        }

        formSubmitted = true; // Set the flag to true to indicate form submission

        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function (response) {
                // Handle the success response if needed
                console.log(response);
                // Refresh the task list after successful form submission
                refreshTaskList();
            },
            error: function (error) {
                // Handle the error response if needed
                console.log(error);
            }
        });
    });

    // Function to refresh the task list after form submission
    function refreshTaskList() {
        $.ajax({
            url: "tasks/getTaskList.php", // Replace with the actual URL to fetch the updated task list
            success: function (data) {
                $(".card-body .list-group").html(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});