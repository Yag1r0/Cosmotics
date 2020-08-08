<?php
@session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();

$orderBy = 'DESC';
if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], ['ASC', 'DESC'])) {
	$orderBy = $_GET['orderBy'];
}

?>
<h2 class='prodH2'>Feautured Products</h2>
<form class='productSort' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
	<select name='orderBy' class='selectAsc'>
		<option value='DESC' <?php echo($orderBy === 'DESC' ? 'selected' : ''); ?>>Price high to low</option>
		<option value='ASC' <?php echo($orderBy === 'ASC' ? 'selected' : ''); ?>>Price low to high</option>
	</select>
	<input type='submit' value='GO' class='goProducts' />
</form>
<div id="product-grid">
	
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY price {$orderBy};");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="cart.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
			<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
			<div class="product-tile-footer">
			<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
			<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
			<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
			</div>
			</form>
		</div>
	<?php
		}
	}
	?>
</div>
</BODY>
</HTML>