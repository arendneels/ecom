<?php 
create_user();
delete_user();
 ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                    <div class="col-lg-12">
                      

                        <h1 class="page-header">
                            Users
                         
                        </h1>
                          <p class="bg-success">
                            <?php echo display_message(); ?>
                        </p>

                        <form action="" method="post">

                            <?php
                                insert_user();
                            ?>
                            <select name="aantal" id="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <input type="submit" class="btn-btn-primary" name="add_user" value="Add new line">
                            <input type="submit" class="btn-btn-primary" name="submit">
                        </form>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>E-mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php get_users(); ?>
                                </tbody>
                            </table> <!--End of Table-->
                        
                        </div>
                        
                    </div>
    

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->