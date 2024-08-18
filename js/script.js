$(document).ready(function(){
    //   adding users
$(document).on("submit","#addform",function(e){
    e.preventDefault();;
    //ajax
    //ajax
    $.ajax({
        url:"./ajax.php",
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
                alert("User added successfully!"); // Optional: Notify the user
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
// get users functions
function getusers(){
    var pageno = $("#currentpage").val();
    $.ajax({
        url:"./ajax.php",
        type:"POST",
        dataType: "json",
        data: {page:pageno ,action:'getallusers'},

        beforeSend:function(){
            console.log("Wait... Data is Loading")
        },
        success: function(row) {
         consol.log(row);
        },
        error: function(request, error) {
            console.log(arguments);
           console.log("Error"+error)
}
    });
};
    
});