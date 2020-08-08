<?php

include "views/fixed/head.php";
include "views/fixed/nav.php";

@session_start();

require_once("dbcontroller.php");
$db_handle = new DBController();
//u slucaju dodavanja novog itema u korpu, pravimo niz u koji ubacujemo sve sto nam je baza vratila tako sto dobijam product
//uz pomoc coda, zatim to pakujemo u novi niz i prikazujemo, zapravo radimo bindovanje na niz
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			$itemArray = array(
				$productByCode[0]["code"]=> array(
					'name'=>$productByCode[0]["name"], 
					'code'=>$productByCode[0]["code"], 
					'quantity'=>$_POST["quantity"], 
					'price'=>$productByCode[0]["price"], 
					'image'=>$productByCode[0]["image"]));
			
		    //proveravamo da li je item vec dodat jednom u korpu, ako jeste povecavamo samo quantity, ako nije
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
					//dodajemo ceo array u cart-item session i spajamo sa ostatkom ukoliko ga ima, ukoliko nema
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}

				//samo stavljamo novi item u korpu
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	//ovde brise samo odredjeni item na koji je kliknuo iz korpe, a nalazi taj item uz pomoc key
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	//ovde se unsetujes sesija ako se klikne na empty card, to znaci da se brise sve iz sesije i korpa je prazna
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}

$quantity = 0;
foreach ($_SESSION["cart_item"] as $item){
	$quantity += $item["quantity"];
}
$_SESSION['cart_quantity'] = $quantity;
header('Location: cart.php');
}
?>

<HTML>
<BODY>
<div id="shopping-cart">
<div class="txt-heading">Shopping Cart</div>

<a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
				<td><?php echo $item["code"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="cart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>		
  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>

<?php include "views/fixed/footer.php"; ?>

