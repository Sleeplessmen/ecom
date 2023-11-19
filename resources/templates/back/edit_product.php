<div class="col-md-12">
<div class="row">
<h1 class="page-header">
  Edit Product
</h1>
</div>

<form action="" method="post" enctype="multipart/form-data">

<div class="col-md-8">
<?php

if(isset($_GET['id'])) {

$query = query("SELECT * FROM products WHERE productID = " . escape_string($_GET['id']));
confirm($query);

while($row = fetch_array($query)) {

$productName = escape_string($row['productName']);
$categoryID = escape_string($row['categoryID']);
$productPrice = escape_string($row['productPrice']);
$productQuantityInStock = escape_string($row['productQuantityInStock']);
$productDescription = escape_string($row['productDescription']);
$productImage = escape_string($row['productImage']);
 
}
}

update_product();

?>


  <div class="form-group">
      <label for="product-title">Product Name</label>
      <input type="text" name="productName" class="form-control" value="<?php echo $productName; ?>"> 
  </div>

  <div class="form-group">
      <label for="product-title">Product Description</label>
      <textarea name="productDescription" id="" cols="30" rows="10" class="form-control"><?php echo $productDescription; ?></textarea>
  </div>

  <div class="form-group row">
    <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" step="any" min="0" name="productPrice" class="form-control" size="60" value="<?php echo $productPrice ?>">
    </div>
  </div>

</div><!--Main Content-->
<!-- SIDEBAR-->

<aside id="admin_sidebar" class="col-md-4">

     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
    </div>

     <!-- Product Categories-->
    <div class="form-group">
        <label for="product-title">Product Category</label>

        <select name="categoryID" id="" class="form-control">
            <option value=""><?php echo show_product_category_name($categoryID); ?></option> 
            <?php show_categories_add_product_page(); ?>
        </select>
    </div>

    <!-- Product QuantityInStock-->
    <div class="form-group">
      <label for="product-title">Product Quantity</label>
      <input type="number" name="productQuantityInStock" class="form-control" value="<?php echo $productQuantityInStock ?>">
    </div>


    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="imageToUpload"> <br>
        <img width='200' src="../../resources/<?php echo $productImage; ?>
    </div>


</aside><!--SIDEBAR-->


    
</form>
 