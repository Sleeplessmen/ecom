<?php require_once("../../config.php");


if(isset($_GET['id'])) {

$query = query("DELETE FROM orders WHERE orderID = " . escape_string($_GET['id']) . " ");
confirm($query);

set_message("Orders deleted");
redirect("../../../public/admin/index.php?orders");

} else {

redirect("../../../public/admin/index.php?orders");

}



?>