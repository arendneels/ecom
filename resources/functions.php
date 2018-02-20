<?php

/** HELPER FUNCTIES **/

    function last_id(){
        global $connection;
        return mysqli_insert_id($connection);
    }

    function set_message($msg){
        if(!empty($msg)){
            $_SESSION['message']=$msg;
        }
        else{
            $msg = "";
        }
    }
    function display_message(){
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }else{
            return;
        }
    }
    function query($sql){
        global $connection;
        return mysqli_query($connection, $sql);
    }
    function confirm($result){
        global $connection;
        if(!$result){
            die("QUERY FAILED" . mysqli_error($connection));
        }
    }
    function fetch_array($result){
        return mysqli_fetch_array($result);
    }

    /* om sql injecties tegen te gaan */
    function escape_string($string){
        global $connection;
        return mysqli_real_escape_string($connection, $string);
    }

    /* rdirect*/
    function redirect($location){
        header("Location: $location");
    }
/**EINDE HELPER FUNCTIES**/
    //get products
    function get_products(){
        $query = query("SELECT * FROM products");
        confirm($query);

        //Paginatie
        $rows = mysqli_num_rows($query);
        if(isset($_GET['page'])){
            $page = preg_replace('#[^0-9]#', '', $_GET['page']);
        }else{
            $page = 1;
        }
        $perPage = 6; //Aantal items per pagina
        $lastPage = ceil($rows/$perPage);

        if($page <1){
            $page = 1;
        }elseif($page > $lastPage){
            $page = $lastPage;
        }

        $middleNumbers = '';

        $sub1 = $page -1;
        $sub2 = $page -2;
        $add1 = $page +1;
        $add2 = $page +2;

        if($page == 1){
            $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
            $middleNumbers .= '<li class="page-item"><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' . $add1 . '</a></li>';
        }elseif($page == $lastPage){
            $middleNumbers .= '<li class="page-item"><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        }elseif($page > 2 && $page < ($lastPage - 1)){
            $middleNumbers .= '<li class="page-item"><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub2 . '">' . $sub2 . '</a></li>';
            $middleNumbers .= '<li class="page-item"><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
            $middleNumbers .= '<li class="page-item"><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' . $add1 . '</a></li>';
            $middleNumbers .= '<li class="page-item"><a href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">' . $add2 . '</a></li>';
        }elseif($page > 1 && $page < $lastPage){
            $middleNumbers .= '<li class="page-item"><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
            $middleNumbers .= '<li class="page-item"><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' . $add1 . '</a></li>';
        }

        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        $query2 = query("SELECT * FROM products $limit");
        confirm($query2);

        $outputPagination = "";

        if($page != 1){
            $prev = $page -1;
            $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'">Back</a></li>';
        }

        $outputPagination .=$middleNumbers;

        if($page != $lastPage){
            $next = $page +1;
            $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next</a></li>';
        }
        echo "<div class='row'>";


        while ($row = fetch_array($query2)){
            $product_image = display_image($row['product_image']);
            $product = <<<DELIMETER
                    <div class="col-sm-4 col-lg-4 col-md-4" height="250px">
                        <div class="thumbnail">
                            <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" width="150px" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">&euro;&nbsp;{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                                </h4>
                                <p>{$row['short_desc']}</p>   
                             <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
                            </div>

                        </div>
                    </div>
DELIMETER;
        echo $product;

        }
        echo "</div> <ul class='pagination'>" . $outputPagination . "</ul>";
    }

    /*get categories*/
    function get_categories(){
        $query = query("SELECT * FROM categories");
        confirm($query);

        while($row = fetch_array($query)){
            $categories_links=<<<DELIMETER
            <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
            echo $categories_links;
        }
    }
/** Get products in category page **/
function get_products_in_cat_page(){
    $query = query("SELECT * FROM products WHERE product_category_id = " .escape_string($_GET['id']) . " ");
    confirm($query);

    while($row = fetch_array($query)){
        $product_image = display_image($row['product_image']);
        $product=<<<DELIMETER
  <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" width="150px" alt="">
                    <div class="caption">
                        <div class="row">
                            <div class="col-xs-6">
                                <h3><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h3>
                            </div>
                            <div class="col-xs-6">
                                <p>&euro;&nbsp;{$row['product_price']}</p>
                            </div>
                        </div>
                        
                                       
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="item.php?id={$row['product_id']}" class="btn btn-primary">ADD TO CART</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;

    echo $product;
    }

}
/* dit is mijn code voor het ophalen van alle producten in shop.**/
function get_products_in_shop_page(){
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){
        $product_image = display_image($row['product_image']);
        $product=<<<DELIMETER
  <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" width="150px" alt="">
                    <div class="caption">
                        <div class="row">
                            <div class="col-xs-6">
                                <h3><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h3>
                            </div>
                            <div class="col-xs-6">
                                <p>&euro;&nbsp;{$row['product_price']}</p>
                            </div>
                        </div>
                        
                                       
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="item.php?id={$row['product_id']}" class="btn btn-primary">ADD TO CART</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;

        echo $product;
    }

}

/**USER INLOG FUNCTIE**/
function login_user(){
   if (isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * from users WHERE username= '{$username}' AND password= '{$password}'");
        confirm($query);

        if(mysqli_num_rows($query)== 0){
            set_message("Uw paswoord en/of username zijn verkeerd");
            redirect("login.php");
        }else{
            $_SESSION['username'] = $username;
            redirect("admin");
        }
    }
}

/***SEND MESSAGE**/
function send_message(){
    if(isset($_POST['submit'])){
       $to = "eenemailadres@mijndomein.com";
       $from_name =  escape_string($_POST['name']);
       $subject = $_POST['subject'];
        $phone = $_POST['phone'];
       $email = $_POST['email'];
       $message = $_POST['message'];

       $headers = "Van: {$from_name} {$email}";
       /*we gebruiken de standaard mail functie van php als voorbeeld.*/

        $result = mail($to, $subject,$phone, $message, $headers);

        if (!$result){
            set_message("Uw bericht werd NIET verstuurd");
        }else{
            set_message("Bericht verstuurd");
        }
    }
}

//BACKEND FUNCTIES
//DISPLAY ORDERS FUNCTIE
function display_orders(){
    $query = query("SELECT * FROM orders ORDER BY order_id DESC");
    confirm($query);

    while($row = fetch_array($query)){
        $order =<<<DELIMETER
        <tr>
            <td>{$row['order_id']}</td>
            <td><img src="http://placehold.it/62x62" alt=""></td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_currency']}</td>
            <td>{$row['order_status']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
        echo $order;
    }
}

function get_products_in_admin(){
    $query = query("SELECT * FROM products ORDER BY product_id DESC");
    confirm($query);

    while($row = fetch_array($query)){
        $category = show_product_category_title($row['product_category_id']);
        $product_image = display_image($row['product_image']);
        $product =<<<DELIMETER
        <tr>
            <td>{$row['product_id']}</td>
            <td><a href="index.php?edit_product&id={$row['product_id']}">{$row['product_title']}</a></td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td>{$row['product_description']}</td>
            <td>{$row['short_desc']}</td>
            <td><a href="index.php?edit_product&id={$row['product_id']}"><img class="img-responsive" width="150px" src="../../resources/{$product_image}" alt=""></a></td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
        echo $product;
    }
}

//ADD PRODUCTS
function add_product(){
    if(isset($_POST['publish'])){
        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $product_short_desc = substr(escape_string($_POST['short_desc']), 0, 50);
        $product_quantity = escape_string($_POST['product_quantity']);
        $product_image = escape_string($_FILES['file']['name']);
        $image_temp_location = $_FILES['file']['tmp_name'];

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        $query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, short_desc, product_quantity, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$product_short_desc}', '{$product_quantity}', '{$product_image}')");
        $last_id = last_id();
        confirm($query);

        set_message("New product {$product_title} with id {$last_id} was added.");
        redirect("index.php?products");
    }
}

//FETCH CATEGORY
function show_categories_add_product(){
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row=fetch_array($query)){
        $categories_options =<<<DELIMETER
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;
        echo $categories_options;
    }
}

//WEERGAVE CATEGORIE TITEL
function show_product_category_title($product_category_id){
    $query = query("SELECT * FROM categories WHERE cat_id= '{$product_category_id}'");
    confirm($query);
    while($category_row = fetch_array($query)){
        return $category_row['cat_title'];
    }
}

//UPLAOD DIRECTORY DYNAMISCH
$upload_directory = "uploads";
function display_image($picture){
    global $upload_directory;
    return $upload_directory . DS . $picture;
}

//Update products
function update_product(){
    if(isset($_POST['update'])){
        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $product_short_desc = substr(escape_string($_POST['short_desc']), 0, 50);
        $product_quantity = escape_string($_POST['product_quantity']);
        $product_image = escape_string($_FILES['file']['name']);
        $image_temp_location = $_FILES['file']['tmp_name'];

        if(empty($product_image)){
            $query_pic = query("SELECT product_image FROM products WHERE product_id =" . escape_string($_GET['id']) . " ");
            confirm($query_pic);

            while($pic = fetch_array($query_pic)){
                $product_image = $pic['product_image'];
            }
        }

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        $query = "UPDATE products SET ";

        $query .= "product_title        ='{$product_title}', ";
        $query .= "product_category_id        ='{$product_category_id}', ";
        $query .= "product_price        ='{$product_price}', ";
        $query .= "product_description        ='{$product_description}', ";
        $query .= "short_desc        ='{$product_short_desc}', ";
        $query .= "product_quantity        ='{$product_quantity}', ";
        $query .= "product_image        ='{$product_image}' ";
        $query .= "WHERE product_id=" . escape_string($_GET['id']);

        $send_update_query = query($query);
        confirm($query);

        set_message("Updated product {$product_title}");
        if(isset($_GET['fromadmin'])){
            redirect("index.php");
        }else{
        redirect("index.php?products");
        }
    }
}

function get_categories_in_admin(){
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){
        $categories =<<<DELIMETER
        <tr>
            <td>{$row['cat_id']}</td>
            <td>{$row['cat_title']}</td>
            <td><a href="index.php?edit_categories&id={$row['cat_id']}" class="btn btn-primary">Edit Name</a></td>
        </tr>
DELIMETER;
        echo $categories;
    }
}

function add_category(){
    if(isset($_POST['submit']) && $_POST['cat_name']<>""){
        $cat_title = escape_string($_POST['cat_name']);

        $query = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}')");
        confirm($query);

        set_message("New category was added.");
        redirect("index.php?categories");
    }
}

function edit_category($cat_id){
    if(isset($_POST['submit']) && $_POST['cat_name']<>""){
        $cat_title = escape_string($_POST['cat_name']);

        $query = query("UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}");
        confirm($query);

        set_message("The category was edited.");

        if(isset($_GET['fromadmin'])){
            redirect("index.php");
        }else{
            redirect("index.php?categories");
        }
    }
}

function get_orders_admin_content(){
    $query = query("SELECT * FROM orders");
    confirm($query);

    while($row = fetch_array($query)){
        $orders=<<<DELIMETER
        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_status']}</td>
            <td>{$row['order_currency']}</td>
        </tr>
DELIMETER;
        echo $orders;
    }
}

function get_products_admin_content(){
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){
        $product_image = display_image($row['product_image']);
        $product_cat = show_product_category_title($row['product_category_id']);
        $products=<<<DELIMETER
        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}</td>
            <td>{$product_cat}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><img src="../../resources/{$product_image}" width="40" alt=""></td>
            <td><a href="index.php?edit_product&id={$row['product_id']}&fromadmin" class="btn btn-primary">EDIT</a></td>
        </tr>
DELIMETER;
        echo $products;
    }
}

function get_categories_admin_content(){
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){
        $categories=<<<DELIMETER
        <tr>
            <td>{$row['cat_id']}</td>
            <td>{$row['cat_title']}</td>
            <td><a class="btn btn-primary" href="index.php?edit_categories&id={$row['cat_id']}&fromadmin">EDIT</a></td>
        </tr>
DELIMETER;
        echo $categories;
    }
}

function get_users(){
    $query = query("SELECT * FROM users");
    confirm($query);

    while($row = fetch_array($query)){
        $users =<<<DELIMETER
        <tr>
            <td>{$row['user_id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['email']}</td>
            <td><a class="btn btn-danger" href="index.php?users&delete_id={$row['user_id']}">X</a></td>                         
        </tr>
DELIMETER;
        echo $users;
    } 
}

function create_user(){
    if(isset($_POST['submit'])){
        for($i=1; $i<=$insert_amount; $i++){
            if($_POST['username_' . $i]<>"" && $_POST['password' . $i]<>""){
                $username = escape_string($_POST['username_' . $i]);
                $email = escape_string($_POST['email_' . $i]);
                $password = escape_string($_POST['password_' . $i]);

                $query = query("INSERT INTO users(username, email, password) VALUES('{$username}', '{$email}', '{$password}')");
                confirm($query);

            }
            set_message("New users were added.");
            redirect("index.php?users");
        }
    }
}

function delete_user(){
    if(isset($_GET['delete_id'])){
        $query = query("DELETE FROM users WHERE user_id =" . $_GET['delete_id']);
        confirm(query);

        redirect("index.php?users");
    }
}

function insert_user(){
    if(isset($_POST['add_user'])){
        for($i=1; $i<=$_POST['aantal'];$i++){
            $insert_user =<<<DELIMETER
                <input type="text" placeholder="Username" name="username_{$i}">
                <input type="text" placeholder="E-mail" name="email_{$i}">
                <input type="password" placeholder="Password" name="password_{$i}">
                <br><br>
DELIMETER;
                echo $insert_user;
        }
        $insert_amount = ($i-1);
    }
}

?>