 <!-- <?php
        // require_once 'partials/connect.php';
        // $dbobj = new Database();
        // var_dump($db)
        ?>  -->

 <!doctype html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>PHP Advance Crud</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
         integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
 </head>

 <body>
     <h1 class="bg-dark text-light text-center py-2 ">PHP ADVANCE CRUD</h1>
     <div class="container my-3 ">
         <!-- form model -->
         <?php include 'form.php' ?>
        <!-- profile mode -->
         <?php include 'profile.php' ?>
         <div class="row mb-3">
             <div class="col-10">
                 <div class="input-group">
                     <div class="input-group-prepend">
                         <span class="input-group-text bg-dark">
                             <i class="fas fa-search text-light py-2"></i>
                         </span>
                     </div>
                     <input type="text" name="" id="" class="form-control" placeholder="Search User">
                 </div>
             </div>
             <div class="col-2">
                 <button class="btn btn-dark py-2" type="button"
                     data-bs-toggle="modal" data-bs-target="#usermodal">
                     Add New User
                 </button>
             </div>
         </div>
         <!-- table -->
         <?php include 'tableData.php' ?>

         <!-- PAGINATION -->
         <nav aria-label="Page navigation example" id="pagination">
             <ul class="pagination justify-content-center">
                 <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                 <li class="page-item active"><a class="page-link" href="#">1</a></li>
                 <li class="page-item"><a class="page-link" href="#">2</a></li>
                 <li class="page-item"><a class="page-link" href="#">3</a></li>
                 <li class="page-item"><a class="page-link" href="#">Next</a></li>
             </ul>
         </nav>

     </div>


     <!-- BootStrap Pooper and js link -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
         integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
         crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
         integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
         crossorigin="anonymous"></script>
     <!-- JQUERY CDN -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"
         integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
         crossorigin="anonymous"></script>
 </body>

 </html>