$(document).on("click", ".pagination .page-link", function(e) {
    e.preventDefault();
    var page = $(this).data("page");
    if (page) {
        $("#currentpage").val(page); // Update the hidden input with the new page
        getusers(); // Fetch users for the selected page
    }
});
function getuserrow(user) {
    var userRow = "";
    if (user) {
        userRow = `<tr>
            <td scope="row"><img src="./uploads/${user.image}" alt="User Image"></td>
            <td>${user.username}</td>
            <td>${user.email}</td> <!-- Corrected this line -->
            <td>${user.mobile}</td>
            <td>
                <a href="#" class="me-3 profile" title="View Profile" data-id="${user.id}" data-bs-target="#userViewModal" data-bs-toggle="modal"><i class="fas fa-eye text-success"></i></a>
                <a href="#" class="me-3 edituser" title="Edit" data-id="${user.id}" data-bs-target="#usermodal" data-bs-toggle="modal"><i class="fas fa-edit text-info"></i></a>
                <a href="#" class="me-3 deleteuser" title="Delete User" data-id="${user.id}"><i class="fas fa-trash-alt text-danger"></i></a>
            </td>
        </tr>`;
    }
    return userRow;
}



// get users functions
function getusers() {
    var pageno = $("#currentpage").val();
    $.ajax({
        url: ".advance_crud/ajax.php",
        type: "GET",
        dataType: "json",
        data: { page: pageno, action: 'getallusers' },
        beforeSend: function () {
            console.log("Wait... Data is Loading");
        },
        success: function (rows) {
            console.log(rows);
            if (rows.status === 'success' && rows.data.users) {
                var userslists = "";
                $.each(rows.data.users, function (index, user) {
                    userslists += getuserrow(user);
                });
                $("#usertable tbody").html(userslists); // Corrected selector
            } else {
                alert("No users found.");
            }
        },
        error: function (request, error) {
            console.log(arguments);
            console.log("Error" + error);
        }
    });
}
//loading document
$(document).ready(function(){
    //   adding users
$(document).on("submit","#addform",function(e){
    e.preventDefault();;
    //ajax
    //ajax
    $.ajax({
        url:".advance_crud/ajax.php",
        type:"POST",
        dataType: "json",
        data:new FormData(this),
        processData:false,
        contentType:false,
        beforeSend:function(){
            console.log("Wait... Data is Loading")
        },
        success: function(response) {
            console.log(response);
            if (response.status === 'success') {
                $("#usermodal").modal("hide");
                $("#addform")[0].reset();
                alert("User added successfully!");
                getusers();                // Optional: Notify the user
            } else {
                alert("Error: " + response.message); // Show error message if any
            }
        },
        error: function(request, error) {
            console.log(arguments);
            alert("An error occurred: " + request.responseText); // Show the error message
        }
    });
});


//calling function getuser
getusers();
    
});