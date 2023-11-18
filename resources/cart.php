<?php require_once("config.php"); ?>

<?php 

if(isset($_GET['add'])) {

$query = query("select * from products where productID = " . escape_string($_GET['add']) . " ");
confirm($query);

while($row = fetch_array($query)) {
    
if($row['productQuantityInStock'] != $_SESSION['product_' . $_GET['add']]) {

    $_SESSION['product_' . $_GET['add']] += 1;
    redirect("../public/checkout.php");

} else {
    set_message("We only have " . $row['productQuantityInStock'] . " " . " available");
    redirect("../public/checkout.php");

}

}

}


if(isset($_GET['remove'])) {
    $_SESSION['product_' . $_GET['remove']]--;

    if($_SESSION['product_' . $_GET['remove']] < 1) {
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']); 
        redirect("../public/checkout.php");
    } else {
        redirect("../public/checkout.php");
    }

}



if(isset($_GET['delete'])) {

    $_SESSION['product_' . $_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']); 
    redirect("../public/checkout.php");
}


function cart() {

$total = 0;
$item_quantity = 0;
$item_name = 1;
$item_number = 1;
$amount = 1;
$quantity = 1;

foreach ($_SESSION as $name => $value) {
if($value > 0) {
$id = substr($name, 8);
if(substr($name, 0, 8) == "product_")  {

$query = query("select * from products where productID = " . escape_string($id) . " ");
confirm($query);

while($row = fetch_array($query)) {
$subtotal = $row['productPrice'] * $value;
$item_quantity += $value;

$product = <<<DELIMETER
<tr>
    <td>{$row['productName']}</td>
    <td>&#36;{$row['productPrice']}</td>  
    <td>{$value}</td>
    <td>&#36;{$subtotal}</td>
    <td>
    <a class='btn btn-warning' href="../resources/cart.php?remove={$row['productID']}"><span class='glyphicon glyphicon-minus'></span></a>       
    <a class='btn btn-success' href="../resources/cart.php?add={$row['productID']}"><span class='glyphicon glyphicon-plus'></span></a>
    <a class='btn btn-danger' href="../resources/cart.php?delete={$row['productID']}"><span class='glyphicon glyphicon-remove'></span></a>
    </td>
</tr>

<input type="hidden" name="item_name_{$item_name}" value="{$row['productName']}">
<input type="hidden" name="item_number_{$item_number}" value="{$row['productID']}">
<input type="hidden" name="amount_{$amount}" value="{$row['productPrice']}">
<input type="hidden" name="quantity_{$quantity}" value="{$value}">

DELIMETER;

echo $product;

$item_name++;
$item_number++;
$amount++;
$quantity++;
} 

$_SESSION['item_total'] = $total += $subtotal;
$_SESSION['item_quantity'] = $item_quantity;
}   
}
}

}


function show_paypal() {

if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity']  >= 1) {

$paypal_button = <<<DELIMETER
<input type="image" name="upload" 
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" 
alt="PayPal - The safer, easier way to pay online"> 

DELIMETER;

return $paypal_button;

}
}




function process_transaction() {

if(isset($_GET['tx'])) {

$amount = $_GET['amt'];
$currency = $_GET['cc'];
$transaction = $_GET['tx'];
$status = $_GET['st'];

$total = 0;
$item_quantity = 0;

foreach ($_SESSION as $name => $value) {
if($value > 0 && substr($name, 0, 8) == "product_")  {

$send_order = query("
INSERT INTO orders(orderAmount, orderTransaction, orderStatus, orderCurrency) 
VALUES('$amount', '$transaction', '$status', '$currency')");
confirm($send_order);
$last_order_id = last_id();

$id = substr($name, 8);
$query = query("select * from products where productID = " . escape_string($id) . " ");
confirm($query);

while($row = fetch_array($query)) {
$subtotal = $row['productPrice'] * $value;
$item_quantity += $value;
$productPrice = $row['productPrice'];
$productName = $row['productName'];

$insert_report = query("INSERT INTO 
reports(productID, productName, orderID, productPrice, productQuantityInStock) 
VALUES('$id', '$productName', '$last_order_id', '$productPrice', '$value')");
confirm($insert_report);

} 
$total += $subtotal;
$item_quantity;
}   
}
session_destroy();
} else {
    
redirect("index.php");

}

}



?> 