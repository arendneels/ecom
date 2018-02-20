<div id="page-wrapper">
<div class="container-fluid">
        <div class="col-md-12">
<div class="row">
    <h1 class="page-header">All Orders</h1>
    <h2 class="bg-danger"><?php display_message(); ?></h2>
</div>
<div class="row">
<table class="table table-hover">
    <thead>
      <tr>
           <th>Order ID</th>
           <th>Image</th>
           <th>Total price</th>
           <th>Transaction number</th>
           <th>Currency</th>
           <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php display_orders(); ?>
    </tbody>
</table>
</div>
</div>
</div>