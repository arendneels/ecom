<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK . DS . "header.php"); ?>
<?php 
    if(!isset($_SESSION['username'])){
        redirect("../../public");
    }

 ?>

        <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
<?php 
    include(TEMPLATE_BACK . DS . "top-nav.php");
    include(TEMPLATE_BACK . DS . "side-bar.php");
?>
            <!-- /.navbar-collapse -->
        </nav>

        <?php
            if($_SERVER['REQUEST_URI']== "/ecom/public/admin/" ||
               $_SERVER['REQUEST_URI']=="/ecom/public/admin/index.php"){
                include(TEMPLATE_BACK .DS. "admin_content.php");
            }
            if(isset($_GET['orders'])){
                include(TEMPLATE_BACK . DS . "orders.php");
            }
            if(isset($_GET['add_product'])){
                include(TEMPLATE_BACK . DS . "add_product.php");
            }
            if(isset($_GET['products'])){
                include(TEMPLATE_BACK . DS . "products.php");
            }
            if(isset($_GET['categories'])){
                include(TEMPLATE_BACK . DS . "categories.php");
            }
            if(isset($_GET['users'])){
                include(TEMPLATE_BACK . DS . "users.php");
            }
            if(isset($_GET['edit_product'])){
                include(TEMPLATE_BACK . DS . "edit_product.php");
            }
            if(isset($_GET['edit_categories'])){
                include(TEMPLATE_BACK . DS . "edit_categories.php");
            }
        ?>
    </div>
    <!-- /#wrapper -->
<?php include(TEMPLATE_BACK . DS . "footer.php"); ?>