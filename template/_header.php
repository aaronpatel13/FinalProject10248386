<?php

$objCatalogue = new Catalogue();
$cats = $objCatalogue->getCategories();

$objBusiness = new Business();
$business = $objBusiness->getBusiness();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Eastern Alchemist | Restaurant</title>
<meta name="description" content="Ecommerce website project" />
<meta name="keywords" content="Ecommerce website project" />
<meta http-equiv="imagetoolbar" content="no" />
<link href="/css/core.css" rel="stylesheet" type="text/css" />


</head>
<body>
<div id="header">
	<div id="header_in">
		<h5><a href="/"><?php echo $business['name']; ?></a></h5>

		<div id="menu">
<ul>
<ul><li><a href="/?page=index">Home</a></li>
<li><a href="/?page=aboutus">About Us</a></li>
<li><a href="/?page=contactus">Contact Us</a></li>
</ul>
</div>


	<?php
			if (Login::isLogged(Login::$_login_front)) {
				echo '<div id="logged_as">Logged in as: <strong>';
				echo Login::getFullNameFront(Session::getSession(Login::$_login_front));
				echo '</strong> | <a href="/?page=orders">My orders</a>';
				echo ' | <a href="/?page=logout">Logout</a></div>';				
			} else {
				echo '<div id="logged_as"><a href="/?page=login">Login / Register</a></div>';
			}
		?>
	</div>
</div>
<div id="outer">
	<div id="wrapper">
		<div id="left">


			<? require_once('basket_left.php'); ?>
			<?php if (!empty($cats)){ ?>
			<h2>Menus</h2>
			<ul id="navigation">
				<?php	foreach($cats as $cat){
						echo "<li><a href=\"/?page=catalogue&amp;category=".$cat['id']."\"";
						echo Helper::getActive(array('category' => $cat['id']));
						echo ">";
						echo Helper::encodeHtml($cat['name']);
						echo "</a></li>";
					}

					?>
					</ul>
			<h2> Opening Hours </h2>
			<p1> <strong>Monday</strong> 12:00pm - 11:00pm</p1><br>
			<p1> <strong>Tuesday</strong> 12:00pm - 11:00pm</p1><br>
			<p1> <strong>Wednesday</strong> 12:00pm - 11:00pm</p1><br>
			<p1> <strong>Thursday</strong> 12:00pm - 11:00pm</p1><br>
			<p1> <strong>Friday</strong> 12:00pm - 11:00pm</p1><br>
			<p1> <strong>Saturday</strong> 12:00pm - 12:00am</p1><br>
			<p1> <strong>Sunday</strong> 12:00am - 10:00pm</p1><br>



				<?php } ?>
				
					
		</div>
		<div id="right">