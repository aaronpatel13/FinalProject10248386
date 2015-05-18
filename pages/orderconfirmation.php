<?php

login::restrictFront();

$token1 = mt_rand();
$token2 = Login::string2hash($token1);
Session::setSession('token2', $token2);

$objBasket = new Basket();

$out = array();

$session = Session::getSession('basket');

if (!empty($session)){
	$objCatalogue = new Catalogue();
	foreach($session as $key => $value){
		$out[$key] = $objCatalogue->getProduct($key);
	}
}

require_once("_header.php");
?>

<h1> Thank You For Your Order! </h1>

<?php if(!empty($out)){ ?>

<div id ="big_basket">


	<form action ="" method = "post" id = "frm_basket">

		<table cellpadding = "0" cellspacing = "0" border = "0" class="tbl_repeat">

		<tr>
			<th>Item</item>
			<th class="ta_r">Qty</th>
			<th class="ta_r col_15">Price</th>

		</tr>

		<?php foreach ($out as $item){ ?>

		<tr>
			<td> <?php echo $item['name']; ?> </td>
			<td class="ta_r"><?php echo $session[$item['id']]['qty']; ?></td>
			<td class="ta_r">&pound;<?php echo number_format($objBasket->itemTotal($item['price'], $session[$item['id']]['qty']), 2); ?></td>

		</tr>


		<?php } ?>

		<?php if($objBasket->_vat_rate > 0) { ?>

		<tr>
			<td colspan="2" class="br_td">

				Sub-Total: 
			</td>
			<td class="ta_r br_td">
				&pound;<?php echo number_format($objBasket->_sub_total, 2); ?>
			</td>


		</tr>

		<tr>
			<td colspan="2" class="br_td">

				VAT(<?php echo $objBasket->_vat_rate; ?> %)
			</td>
			<td class="ta_r br_td">
			&pound;<?php echo number_format($objBasket->_vat, 2); ?>
			</td>


		</tr>


	      <?php } ?>

	      	<tr>
			<td colspan="2" class="br_td">

				<strong>Total:</strong>
			</td>
			<td class="ta_r br_td">
			<strong>&pound;<?php echo number_format($objBasket->_total, 2); ?></strong>
			</td>


		</tr>


		</table>

		<div class="dev br_td">&#160;</div>



</form>
	
	<div class="dev">&#160;</div>
	
</div>

<h3> You should expect to recieve your order within the next 45 mins. If you have any issues with your order please <a href="/?page=contactus">contact us</a>. </h3>

<div class="sbm sbm_blue fl_l">
		<a onClick="window.print()"  class="btn">Print Your Order</a>
	</div>


<?php } else { ?>

	<p>Your basket is currently empty.</p>

<?php } ?>


<?php
require_once("_footer.php");

?>