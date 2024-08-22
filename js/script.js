//function for paginiton
function pagination(totalpages, currentpages) {
  var pagelist = "";
  if (totalpages > 1) {
    currentpages = parseInt(currentpages);
    pagelist += ` <ul class="pagination justify-content-center">`;
    const prevclass = currentpages == 1 ? "disabled" : "";
    pagelist += ` <li class="page-item ${prevclass}"><a class="page-link" href="#" data-page="${
      currentpages - 1}">Previous</a></li>`;
    for (let p = 1; p <= totalpages; p++) {
      const activeClass = currentpages == p ? "active" : "";
      pagelist += `<li class="page-item  ${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li> `;
    }
    const nextclass = currentpages == totalpages ? "disabled" : "";
    pagelist += `<li class="page-item ${nextclass}" ><a class="page-link" href="#" data-page="${
      currentpages + 1
    }">Next</a></li> `;
    pagelist += `</ul>`;
  }
  $("#pagination").html(pagelist);
}
function getuserrow(user) {
  var userRow = "";
  if (user) {
    userRow = `<tr>
            <td scope="row"><img src="./uploads/${user.image}" alt="User Image"></td>
            <td>${user.username}</td>
            <td>${user.email}</td>
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

function getusers() {
  var pageno = $("#currentpage").val();
  $.ajax({
    url: "./ajax.php",
    type: "GET",
    dataType: "json",
    data: { page: pageno, action: "getallusers" },
    beforeSend: function () {
      console.log("Wait... Data is Loading");
    },
    success: function (rows) {
      console.log(rows);
      if (rows.status === "success" && rows.data.users) {
        var userslists = "";
        $.each(rows.data.users, function (index, user) {
          userslists += getuserrow(user);
        });
        $("#usertable tbody").html(userslists);
        let totaluser = rows.data.count;
        // console.log(totaluser);
        let totalpages = Math.ceil(parseInt(totaluser) / 4);
        const currentpages = $("#currentpage").val();
        pagination(totalpages, currentpages);
        // Update pagination links
      } else {
        alert("No users found.");
      }
    },
    error: function (request, error) {
      console.log(arguments);
      console.log("Error" + error);
    },
  });
}

$(document).ready(function () {
  $(document).on("submit", "#addform", function (e) {
    e.preventDefault();
    $.ajax({
      url: "./ajax.php",
      type: "POST",
      dataType: "json",
      data: new FormData(this),
      processData: false,
      contentType: false,
      beforeSend: function () {
        console.log("Wait... Data is Loading");
      },
      success: function (response) {
        console.log(response);
        if (response.status === "success") {
          $("#usermodal").modal("hide");
          $("#addform")[0].reset();
          alert("User added successfully!");
          getusers();
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function (request, error) {
        console.log(arguments);
        alert("An error occurred: " + request.responseText);
      },
    });
  });
  //function on clickevent for pagination
  $(document).on("click" ,"ul.pagination li a",function(event){
        event.preventDefault();
        const pagenum=$(this).data("page");
        $("#currentpage").val(pagenum);
        getusers();   
})
//onclick event for edit:
$(document).on("click", "a.edituser", function () {
    var uid = $(this).data("id");
    $.ajax({
        url: "./ajax.php",
        type: "GET",
        dataType: "json",
        data: { id: uid, action: "edituserdata" },
        beforeSend: function () {
            console.log("Wait... Data is Loading");
        },
        success: function (response) {
            console.log(response);
            if (response.status === "success") {
                // Populate the form fields with user data
                var user = response.data;
                // Assuming you have form fields with these IDs
                $("#username").val(user.username);
                $("#email").val(user.email);
                $("#mobile").val(user.mobile);
                $("#userId").val(user.id); // Assuming you have a hidden field for user ID
                $("#usermodal").modal("show"); // Show the modal for editing
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function (request, error) {
            console.log(arguments);
            console.log("Error" + error);
        },
    });
});
//onclick for adding userbtn
$("#adduserbtn").on("click",function(){
    $("#addform")[0].reset();
    $("$userId").val("");
})

//onclick event on deleting 
$(document).on("click", "a.deleteuser", function () {
    var userId = $(this).data("id");
    if (confirm("Are you sure you want to delete this user?")) {
        $.ajax({
            url: "./ajax.php",
            type: "GET",
            dataType: "json",
            data: { id: userId, action: "deleteuser" },
            success: function (response) {
                if (response.delete === 1) {
                    alert("User deleted successfully!");
                    getusers(); // Refresh the user list after deletion
                } else {
                    alert("Error: User could not be deleted.");
                }
            },
            error: function (request, error) {
                console.log("Error: " + error);
            }
        });
    }
});
//profile user
// Profile user
$(document).on("click", "a.profile", function () {
    var uid = $(this).data("id");
    $.ajax({
        url: "./ajax.php",
        type: "GET",
        dataType: "json",
        data: { id: uid, action: "edituserdata" },
        success: function (response) {
            if (response.status === "success") {
                const user = response.data; // Ensure this matches your response structure
                const profile = `
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="./uploads/${user.image}" alt="Image" class="rounded">
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4 class="text-primary">${user.username}</h4> <!-- Assuming username is correct -->
                        <p>
                            <i class="fas fa-envelope-open text-dark py-2"></i> ${user.email}
                            <br>
                            <i class="fas fa-phone text-dark py-2"></i> ${user.mobile}
                        </p>
                    </div>
                </div>`;
                $("#profile").html(profile); // Ensure this ID exists in your HTML
            } else {
                alert("Error: " + response.message); // Handle errors
            }
        },
        error: function (request, error) {
            console.log("Error: " + error);
        }
    });
});
   
  getusers();
}); 
