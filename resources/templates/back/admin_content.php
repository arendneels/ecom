<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK . DS . "header.php"); ?>
<?php 
    $query_orders = query("SELECT COUNT(order_id) FROM orders");
    confirm($query_orders);

    $query_products = query("SELECT COUNT(product_id) FROM products");
    confirm($query_products);

    $query_categories = query("SELECT COUNT(cat_id) FROM categories");
    confirm($query_categories);

    $row1=fetch_array($query_orders);
    $total_orders = $row1[0];

    $row2=fetch_array($query_products);
    $total_products = $row2[0];

    $row3=fetch_array($query_categories);
    $total_categories = $row3[0];
 ?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Dashboard <small>Statistics Overview</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- FIRST ROW WITH PANELS -->

        <!-- /.row -->
        <div class="row">

            <div class="col-lg-4 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $total_orders ?></div>
                                <div>New Orders!</div>
                            </div>
                        </div>
                    </div>
                    <a href="index.php?orders">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-lg-5 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $total_products ?></div>
                                <div>Products!</div>
                            </div>
                        </div>
                    </div>
                    <a href="index.php?products">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $total_categories ?></div>
                                <div>Categories!</div>
                            </div>
                        </div>
                    </div>
                    <a href="index.php?categories">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>


        </div>

        <!-- /.row -->


        <!-- SECOND ROW WITH TABLES-->

        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Order Amount</th>
                                    <th>Transaction Code</th>
                                    <th>Status</th>
                                    <th>Currency</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php get_orders_admin_content(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="index.php?orders">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>







            <div class="col-lg-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Products Panel</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php get_products_admin_content(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="index.php?products">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

                        <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Categories Panel</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php get_categories_admin_content(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="index.php?categories">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php include(TEMPLATE_BACK . DS . "footer.php"); ?>
















        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
