<?php

// helper functions

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

$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['productID']}"><img src="{$row['productImage']}" alt=""></a> 
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

$product = <<<DELIMETER

<div class="col-md-3 col-sm-6 hero-feature">
<div class="thumbnail">
    <img src="{$row['productImage']}" alt="">
    <div class="caption">
        <h3>{$row['productName']}</h3>
        <p>{$row['productShortDesc']}</p>
        <p>
            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['productID']}" class="btn btn-default">More Info</a>
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

$product = <<<DELIMETER

<div class="col-md-3 col-sm-6 hero-feature">
<div class="thumbnail">
    <img src="{$row['productImage']}" alt="">
    <div class="caption">
        <h3>{$row['productName']}</h3>
        <p>{$row['productShortDesc']}</p>
        <p>
            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['productID']}" class="btn btn-default">More Info</a>
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




?>
