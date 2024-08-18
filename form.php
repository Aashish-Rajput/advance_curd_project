  <!-- form model -->
        <!-- Modal -->
        <div class="modal fade" id="usermodal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Or Updating Users</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addform" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <!-- INPUT NAME -->
                                <label>Name:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">
                                            <i class="fas fa-user-alt text-light py-2"></i>
                                        </span>
                                    </div>
                                    <input type="text"  class="form-control" placeholder="Enter Your User Name"
                                        autocomplete="off" required="required" id="username" name="username">
                                </div>
                                <!-- INPUT EMAIL -->
                                <label>Email:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">
                                            <i class="fas fa-envelope-open text-light py-2"></i>
                                        </span>
                                    </div>
                                    <input type="email"  class="form-control" placeholder="Enter your Email"
                                        autocomplete="off" required="required" id="email" name="email">
                                </div>
                                <!-- USER MOBILE -->
                                <label>Mobile:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">
                                            <i class="fas fa-phone text-light py-2"></i>
                                        </span>
                                    </div>
                                    <input type="phone" class="form-control" placeholder="Enter your Mobile Number"
                                        autocomplete="off" required="required" id="mobile" name="mobile" maxlength="10" minlength="10">
                                </div>
                                <!-- PRFILE IMAGE -->
                                <label>Image:</label>
                                <div class="input-group">
                                    <label class="custom-file-label me-2" for="userimage">Choose File :</label>
                                     
                                    <input type="file" class="custom-file-input" name="image" accept="image/*"
                                        id="userimage">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark ">Submit</button>
                            <button type="button" class="btn btn-danger"  data-bs-dismiss="modal">Close</button>
                            <!-- 2 input fileds first or add and -->
                            <input type="hidden" name="action" value="adduser">
                             <!-- other for updating or deleting profile; --> 
                            <input type="hidden" name="userId" id="userId">
                        </div>
                    </form>
                </div>
            </div>
        </div>