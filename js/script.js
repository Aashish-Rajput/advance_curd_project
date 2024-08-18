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
        success:function(response){
            console.log(response)
        },
        error:function(request,error){
                console.log(arguments);
                console.log("Error"+error);
        }
    });
});

});