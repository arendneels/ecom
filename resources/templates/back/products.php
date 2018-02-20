
        <div id="page-wrapper">

            <div class="container-fluid">

             <div class="row">

<h1 class="page-header">
   All Products

</h1>
<h2 class="bg-danger"><?php display_message(); ?></h2>

<table class="table table-hover">


    <thead>

      <tr>
           <th>Product ID</th>
           <th>Title</th>
           <th>Category ID</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Description</th>
           <th>Short Description</th>
           <th>Image</th>
      </tr>
    </thead>
    <tbody>

    <?php get_products_in_admin(); ?>

  </tbody>
</table>

             </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
