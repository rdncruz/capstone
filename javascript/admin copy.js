$(document).ready(function() {
    // Handle "Reject" button click
    $(".deleteStudentBtn").click(function() {
        var unique_id = $(this).val();
        var buttonElement = $(this);

        if (confirm("Are you sure you want to reject this seller?")) {
            sendAjaxRequest(unique_id, 'reject', buttonElement);
        }
    });

    // Handle "Approved" button click
    $(".editStudentBtn").click(function() {
        var unique_id = $(this).val();
        var buttonElement = $(this);

        if (confirm("Are you sure you want to approve this seller?")) {
            sendAjaxRequest(unique_id, 'approve', buttonElement);
        }
    });

    function sendAjaxRequest(unique_id, action, buttonElement) {
        $.ajax({
            type: "POST",
            url: "php/admin.php",
            data: {
                unique_id: unique_id,
                action: action
            },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    // Seller operation successful
                    alertify.success(response.message);
                    if (action === "reject" || action === "approve") {
                        // Remove the corresponding table row
                        buttonElement.closest('tr').remove();
                    }
                } else {
                    // Error occurred during the operation
                    alertify.error(response.message);
                }
            },
            error: function() {
                // AJAX request failed
                alertify.error("Failed to perform the operation. Please try again later.");
            }
        });
    }
});
