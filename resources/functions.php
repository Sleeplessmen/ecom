<?php

// helper functions
$upload_directory = "uploads";

function last_id() {

global $connection;
return mysqli_insert_id($connection);

}



function set_message($msg) {

if(!empty($msg)) {
$_SESSION['message'] = $msg;
} else {
$msg = "";
}

}


function display_message() {

if(isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
}

function redirect($location){

header("Location: $location ");

}

function query($sql) {

global $connection;

return mysqli_query($connection, $sql);

}

function confirm($result) {
    global $connection;

    if(!$result) {
    
    die("QUERY FAILED " . mysqli_error($connection));

    }
}

function escape_string($string) {
    
    global $connection;
    return mysqli_real_escape_string($connection, $string);

}


function fetch_array($result) {
    return mysqli_fetch_array($result);

}


/************************************FRONT END FUNCTION***************************/


// get products

function get_products() {

$query = query(" SELECT * FROM products");
confirm($query); 

while($row = fetch_array($query)) {

$productImage = display_image($row['productImage']);

$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['productID']}"><img src="../resources/{$productImage}" alt=""></a> 
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['productPrice']}</h4>
            <h4><a href="item.php?id={$row['productID']}">{$row['productName']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
            <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['productID']}">Add to cart</a>  
        </div>
        
            
    </div>
</div>

DELIMETER;

echo $product; 
} 
}


function get_categories() {

$query = query("SELECT * FROM categories");
confirm($query);

while($row = fetch_array($query)) {

$categories_links = <<<DELIMETER

<a href='category.php?id={$row['categoryID']}' class='list-group-item'> {$row['categoryName']} </a>

DELIMETER;  

echo $categories_links;

}
}


 
function get_products_in_category_page() {

$query = query(" SELECT * FROM products WHERE categoryID = " . escape_string($_GET['id']) . " ");
confirm($query); 

while($row = fetch_array($query)) {

$productImage = display_image($row['productImage']);

$product = <<<DELIMETER

<div class="col-md-3 col-sm-6 hero-feature">
<div class="thumbnail">
    <img src="../resources/{$productImage}" alt="">
    <div class="caption">
        <h3>{$row['productName']}</h3>
        <p>{$row['productDescription']}</p>
        <p>
            <a href="../resources/cart.php?add={$row['productID']}" class="btn btn-primary">Add To Cart</a> <a href="item.php?id={$row['productID']}" class="btn btn-default">More Info</a>
        </p>
    </div>
</div>
</div>

DELIMETER;

echo $product;

} 
}



function get_products_in_shop_page() {

$query = query(" SELECT * FROM products");
confirm($query); 

while($row = fetch_array($query)) {

$productImage = display_image($row['productImage']);

$product = <<<DELIMETER

<div class="col-md-3 col-sm-6 hero-feature">
<div class="thumbnail">
    <img src="../resources/{$productImage}" alt="">
    <div class="caption">
        <h3>{$row['productName']}</h3>
        <p>{$row['productDescription']}</p>
        <p>
            <a href="../resources/cart.php?add={$row['productID']}" class="btn btn-primary">Add To Cart</a> <a href="item.php?id={$row['productID']}" class="btn btn-default">More Info</a>
        </p>
    </div>
</div>
</div>

DELIMETER;

echo $product;

} 
}



function login_user() {

if(isset($_POST['submit'])) {

$username = escape_string($_POST['username']);
$userpassword = escape_string($_POST['password']);

$query = query("SELECT * FROM users WHERE username = '{$username}' AND userpassword = '{$userpassword}' ");
confirm($query);

if(mysqli_num_rows($query) == 0) {

    set_message("Your password or username are wrong.");
    redirect("login.php");

} else {
    $_SESSION['username'] = $username;
    redirect("admin");
}

}
}




function send_message() {

if(isset($_POST['submit'])) {

$to = "someEmailaddress@gmail.com";
$from_name = $_POST['name'];
$subject = $_POST['subject'];
$email = $_POST['email'];
$message = $_POST['message'];

$headers = "From: {$from_name} {$email}";

$result = mail($to, $subject, $message, $headers);
}

if(!$result) {
    set_message("Sorry we could not send your message");
    redirect("contact.php");
} else {
    set_message("Your message has been sent");
    redirect("contact.php");
}

}

/************************************BACK END FUNCTION***************************/

function display_orders() {

$query = query("select * from orders");
confirm($query);

while($row = fetch_array($query)) {

$orders = <<<DELIMETER

<tr>
    <td>{$row['orderID']}</td>
    <td>{$row['orderAmount']}</td>
    <td>{$row['orderTransaction']}</td>
    <td>{$row['orderStatus']}</td>
    <td>{$row['orderCurrency']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['orderID']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>

DELIMETER;

echo $orders;
}
}

/************ Admin View Products Page***********/

function display_image($picture) {
    global $upload_directory;
    return $upload_directory . DS . $picture;
}


function get_products_in_admin() {

$query = query(" SELECT * FROM products");
confirm($query); 

while($row = fetch_array($query)) {

$categoryID = show_product_category_name($row['categoryID']);

$productImage = display_image($row['productImage']);

$product = <<<DELIMETER
<tr>
    <td>{$row['productID']}</td>
    <td>{$row['productName']}<br>
    <a href="index.php?edit_product&id={$row['productID']}"><img width='100' src="../../resources/{$productImage}"></td></a>
    <td>{$categoryID}</td>
    <td>{$row['productPrice']}</td>
    <td>{$row['productQuantityInStock']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['productID']}"><span class="glyphicon glyphicon-remove"></span></a></td>
 
</tr>

DELIMETER;

echo $product; 
} 
}

function show_product_category_name($categoryID) {

$category_query = query("SELECT * FROM categories where categoryID = '{$categoryID}'");
confirm($category_query);

while($category_row = fetch_array($category_query)) {
    return $category_row['categoryName'];
}
}

/***************Admin Add Products ****************/
function add_product() {

if(isset($_POST['publish'])) {

$productName = escape_string($_POST['productName']);
$categoryID = escape_string($_POST['categoryID']);
$productPrice = escape_string($_POST['productPrice']);
$productQuantityInStock = escape_string($_POST['productQuantityInStock']);
$productDescription = escape_string($_POST['productDescription']);
$productImage = escape_string($_FILES['imageToUpload']['name']);
$image_temp_location = escape_string($_FILES['imageToUpload']['tmp_name']);

move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $productImage);

$query = query("INSERT INTO products(productName, categoryID, productPrice, productQuantityInStock, productDescription, productImage) VALUES
('{$productName}', '{$categoryID}', '{$productPrice}', '{$productQuantityInStock}', '{$productDescription}', '{$productImage}')");

$last_product_id = last_id();
confirm($query);

set_message("New product with ID: {$last_product_id} was added");
redirect("index.php?products");

}
}





function show_categories_add_product_page() {

$query = query("SELECT * FROM categories");
confirm($query);

while($row = fetch_array($query)) {

$categories_options = <<<DELIMETER

<option value="{$row['categoryID']}">{$row['categoryName']}</option> 

DELIMETER;  

echo $categories_options;

}
}

/*****************Updating Product*********/
function update_product() {

if(isset($_POST['update'])) {

$productName = escape_string($_POST['productName']);
$categoryID = escape_string($_POST['categoryID']);
$productPrice = escape_string($_POST['productPrice']);
$productQuantityInStock = escape_string($_POST['productQuantityInStock']);
$productDescription = escape_string($_POST['productDescription']);
$productImage = escape_string($_FILES['imageToUpload']['name']);
$image_temp_location = escape_string($_FILES['imageToUpload']['tmp_name']);

if(empty($productImage)) {

$get_pic = query("SELECT productImage FROM products WHERE productID = " . escape_string($_GET['id']));
confirm($get_pic);

while($pic = fetch_array($get_pic)) {
$productImage = $pic['productImage'];
}
}

move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $productImage  );

$query = "UPDATE products SET ";
$query .= "productName = '{$productName}', ";
$query .= "categoryID = '{$categoryID}', ";
$query .= "productPrice = '{$productPrice}', ";
$query .= "productQuantityInStock = '{$productQuantityInStock}', ";
$query .= "productDescription = '{$productDescription}', ";
$query .= "productImage = '{$productImage}' ";
$query .= "WHERE productID = " . escape_string($_GET['id']);

$send_update_query = query($query);
confirm($send_update_query);

set_message("Product has been updated");
redirect("index.php?products");

}
}



    








?>
