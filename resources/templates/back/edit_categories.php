<?php 
if(isset($_GET['id'])){
  $query = query("SELECT * FROM categories WHERE cat_id = " . escape_string($_GET['id']). " ");
  confirm($query);

  while($row = fetch_array($query)){
        $cat_title = escape_string($row['cat_title']);
  }
edit_category($_GET['id']); 
}else{redirect("index.php?categories");
}

?>
        <div id="page-wrapper">

            <div class="container-fluid">

<h1 class="page-header">
  Product Categories
</h1>

<h2 class="text-center bg-danger">
    <?php 
    display_message();
    ?>  
</h2>


<div class="col-md-4">
    
    <form action="" method="post">
    
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" class="form-control" name="cat_name" value="<?php echo $cat_title; ?>">
        </div>

        <div class="form-group">
            
            <input type="submit" name="submit" class="btn btn-primary" value="Edit Name">
        </div>      


    </form>


</div>


<div class="col-md-8">

    <table class="table">
            <thead>

        <tr>
            <th>id</th>
            <th>Title</th>
        </tr>
            </thead>


    <tbody>
        <?php echo get_categories_in_admin() ?>
    </tbody>

        </table>

</div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->