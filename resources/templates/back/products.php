<div class="row">
<h1 class="page-header">All Products</h1>
<h4 class="bg-success"><?php display_message() ?></h4>
<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Category</th>
      <th>Price</th>
      <th>Quantity</th>
    </tr>
  </thead>
  <tbody>
    <?php get_products_in_admin(); ?>
  </tbody>
</table>

</div>

           