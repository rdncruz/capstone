$(document).on('submit', '#saveStudent', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_student", true);

    // Get the unique_id value from the hidden input
    var unique_id = $("#unique_id").val();

    $.ajax({
        type: "POST",
        url: "./php/code.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorMessage').removeClass('d-none');
                $('#errorMessage').text(res.message);
            } else if (res.status == 200) {
                $('#errorMessage').addClass('d-none');
                $('#studentAddModal').modal('hide');
                $('#saveStudent')[0].reset();

                alertify.set('notifier', 'position', 'top-right');
                alertify.success(res.message);

                $('#myTable').load(location.href + " #myTable");
            } else if (res.status == 500) {
                alertify.error(res.message);
            } else if (res.status == 5020) { // Corrected status code
                alertify.error(res.message);
            } else if (res.status == 4222) { // Corrected status code
                alertify.error(res.message);
            }
        }
    });
});


$(document).on('click', '.editStudentBtn', function () {

    var student_id = $(this).val();
    
    $.ajax({
        type: "GET",
        url: "./php/code.php?id=" + student_id,
        success: function (response) {

            var res = jQuery.parseJSON(response);
            if(res.status == 404) {

                alert(res.message);
            }else if(res.status == 200){

                $('#student_id').val(res.data.id);
                $('#category').val(res.data.category);
                $('#name').val(res.data.name);
                $('#small_description').val(res.data.small_description);
                $('#price').val(res.data.price);
                $('#quantity').val(res.data.quantity);
                $('#status').val(res.data.status);

                $('#studentEditModal').modal('show');
            }

        }
    });

});

$(document).on('submit', '#updateStudent', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("update_student", true);

    $.ajax({
        type: "POST",
        url: "./php/code.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            
            var res = jQuery.parseJSON(response);
            if(res.status == 422) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);

            }else if(res.status == 200){

                $('#errorMessageUpdate').addClass('d-none');

                alertify.set('notifier','position', 'top-right');
                alertify.success(res.message);
                
                $('#studentEditModal').modal('hide');
                $('#updateStudent')[0].reset();

                $('#myTable').load(location.href + " #myTable");

            }else if(res.status == 500) {
                alert(res.message);
            }
        }
    });

});

$(document).on('click', '.viewStudentBtn', function () {

    var student_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "./php/code.php?id=" + student_id,
        success: function (response) {

            var res = jQuery.parseJSON(response);
            if(res.status == 404) {

                alert(res.message);
            }else if(res.status == 200){

                $('#view_category').text(res.data.category);
                $('#view_name').text(res.data.name);
                $('#view_small_description').text(res.data.small_description);
                $('#view_price').text(res.data.price);
                $('#view_quantity').text(res.data.quantity);
                $('#view_status').text(res.data.status);

                $('#studentViewModal').modal('show');
            }
        }
    });
});

$(document).on('click', '.deleteStudentBtn', function (e) {
    e.preventDefault();

    if(confirm('Are you sure you want to delete this data?'))
    {
        var student_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "./php/code.php",
            data: {
                'delete_student': true,
                'student_id': student_id
            },
            success: function (response) {

                var res = jQuery.parseJSON(response);
                if(res.status == 500) {

                    alert(res.message);
                }else{
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);

                    $('#myTable').load(location.href + " #myTable");
                }
            }
        });
    }
});