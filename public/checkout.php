<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS. "header.php"); ?>
<?php include(TEMPLATE_FRONT . DS. "top_nav.php"); ?>



    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">

      <h1>Checkout</h1>

    <h2 class="text-center bg-danger"><?php display_message();?></h2>


    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="business" value="seller.arend@testsyntra.be">
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Image</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
        <?php echo cart(); ?>
        </tbody>

    </table>
<?php show_paypal(); ?>
</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>

<td><span class="amount"> <?php echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity']="";?></span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">&euro;&nbsp;
            <?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total']="";?></span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->
        <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>