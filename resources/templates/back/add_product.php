<?php add_product(); ?>_

<div class="col-md-12">
<div class="row">
<h1 class="page-header">
  Add Product
</h1>
</div>

<form action="" method="post" enctype="multipart/form-data">

<div class="col-md-8">
 
  <div class="form-group">
      <label for="product-title">Product Name</label>
      <input type="text" name="productName" class="form-control"> 
  </div>


  <div class="form-group">
      <label for="product-title">Product Description</label>
      <textarea name="productDescription" id="" cols="30" rows="10" class="form-control"></textarea>
  </div>

  <div class="form-group row">
    <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" name="productPrice" class="form-control" size="60">
    </div>
  </div>

  
</div><!--Main Content-->
<!-- SIDEBAR-->

<aside id="admin_sidebar" class="col-md-4">

     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="publish" class="btn btn-primary btn-lg" value="Publish">
    </div>

     <!-- Product Categories-->
    <div class="form-group">
        <label for="product-title">Product Category</label>

        <select name="categoryID" id="" class="form-control">
            <option value="">Select Category</option> 

            <?php show_categories_add_product_page(); ?>
        </select>
    </div>

    <!-- Product Quantity-->
    <div class="form-group">
      <label for="product-title">Product Quantity</label>
      <input type="number" name="productQuantityInStock" class="form-control">
    </div>

    <!-- Product Tags -->
    <!-- <div class="form-group">
          <label for="product-title">Product Keywords</label>
          <hr>
        <input type="text" name="product_tags" class="form-control">
    </div> -->

    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file">
    </div>


</aside><!--SIDEBAR-->


    
</form>
 