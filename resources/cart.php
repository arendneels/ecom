<?php require_once("config.php"); ?>


<?php
// meerdere keren hetzelfde artikel toe voegen
    if(isset($_GET['add'])){
       // $_SESSION['product_' . $_GET['add']]+=1;
       // redirect("index.php");

        $query =  query("SELECT * FROM products where product_id=" .escape_string($_GET['add']) . " ");
        confirm($query);

        while($row = fetch_array($query)){
            if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]){
                $_SESSION['product_' . $_GET['add']]+=1;
                redirect("../public/checkout.php");
            }
            else{
                set_message("We hebben enkel " . $row['product_quantity'] . " artikelen van {$row['product_title']}
                in stock");
                redirect("../public/checkout.php");
            }
        }
    }
?>
<?php
//verminderen van de hoeveelheid van een artikel
if (isset($_GET['remove'])){
    $_SESSION['product_' . $_GET['remove']]--;

    if($_SESSION['product_' . $_GET['remove']]<1){
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("../public/checkout.php");
    }
    else{
        redirect("../public/checkout.php");
    }
}

?>
<?php
//deleten van een volledige artikellijn
if (isset($_GET['delete'])){
        $_SESSION['product_' . $_GET['delete']]= '0';
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("../public/checkout.php");
    }


?>
<?php
function cart(){
//query om al onze producten uit de database te halen
    $total = 0;
    $totalquantity=0;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;

    //$name ='product_1';
    //$ value = 1;
    foreach($_SESSION AS $name => $value){

        //is er geklikt
        if($value > 0){
            //teste als de naam effetief = product_

            //$name bevat product_1
            //
            if(substr($name,0,8)== "product_"){
                $length = strlen($name);
                $id = substr($name, 8, $length);

                $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id). " ");
                confirm($query);

                while($row = fetch_array($query)){
                    $sub = $row['product_price']*$value;
                    $product_image = display_image($row['product_image']);

                    $product=<<<DELIMETER
                <tr>
                <td>{$row['product_title']}</td>
                <td><img src="../resources/{$product_image}" width="50" alt=""></td>
                <td>&euro;&nbsp;{$row['product_price']}</td>
                <td>{$value}</td>
                <td>&euro;&nbsp;{$sub}</td>
                <td><a class="btn btn-warning" href="../resources/cart.php?remove={$row['product_id']}"><span class="glyhpicon glyphicon-minus"></span></a></td>
                 <td><a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"><span class="glyhpicon glyphicon-plus"></span></a></td>
                <td><a class="btn btn-danger" href="../resources/cart.php?delete={$row['product_id']}"><span class="glyhpicon glyphicon-plus"></span></a></td>
            </tr>
            <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
            <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
            <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
            <input type="hidden" name="quantity_{$quantity}" value="{$value}">
            <input type="hidden" name="currency_code" value="EUR">
DELIMETER;
                    echo $product;
                    $item_name++;
                    $item_number++;
                    $amount++;
                    $quantity++;
                }
                $_SESSION['item_total'] = $total += $sub;
                $_SESSION['item_quantity'] = $totalquantity += $value;
            }
            }
        }
    }

    function show_paypal(){
        if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity']>=1){
            $paypal_button=<<<DELIMETER
            <input type="image" name="upload"
               src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
               alt="PayPal - The safer, easier way to pay online">
DELIMETER;
        echo $paypal_button;
        }
    }

//**Functie Reports
function proces_transaction(){
    global $connection;
//query om al onze producten uit de database te halen
    //thank_you.php?tx=123123&amt=234&cc=EUR$st=Completed; Om te testen.
        if(isset($_GET['tx'])) {
            $amount = $_GET['amt'];
            $currency = $_GET['cc'];
            $transaction = $_GET['tx'];
            $status = $_GET['st'];

            $send_order = query("INSERT INTO 
orders(order_amount,order_transaction,order_status,order_currency)
VALUES('{$amount}','{$transaction}','{$status}','{$currency}')");
            confirm($send_order);

            $last_id = last_id();

            $total = 0;
            $item_quantity = 0;

        foreach($_SESSION AS $name => $value){
        //is er geklikt
        if($value > 0){
            //teste als de naam effetief = product_

            //$name bevat product_1
            //
            if(substr($name,0,8)== "product_"){
                $length = strlen($name);
                $id = substr($name, 8, $length);

                $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id). " ");
                confirm($query);

                while($row = fetch_array($query)){
                    $sub = $row['product_price']*$value;
                    $item_quantity += $value;
                    $product_title = $row['product_title'];
                    $product_price = $row['product_price'];
                    $insert_report = query("INSERT INTO reports(product_id, product_price, product_quantity, order_id, product_title) VALUES('{$id}', '{$product_price}', '{$value}', '{$last_id}', '{$product_title}')");
                    confirm($insert_report);
                }
                $total += $sub;
                $item_quantity;
            }
            }
        }
        session_destroy();
        }else{
            redirect("index.php");
        }
    }
?>
