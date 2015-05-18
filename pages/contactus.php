<?php require_once('_header.php'); ?>

<h1> Contact Us</h1>
<h4> Where are we? </h4>

<p>318 Wilmslow Road, Fallowfield </br>
Manchester, M14 6XQ</br>
Phone:01612488989</p>

<div id="all">
    <iframe width="550" height="550" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=M14%206XQ&key=AIzaSyA6_4UY8dLpglV5yj086vt7AUvgLtN_0tM"></iframe>
</div> </br> 

<h4> Email Us </h4>
<?php
$action=$_REQUEST['action'];
if ($action=="")  
    {
    ?>
    <form  action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit">
    <th>Your name:</th><br>
    <td><input name="name" type="text" value="" size="30" style="border:solid 1px grey;"/></td><br>
    Your email:<br>
    <input name="email" type="text" value="" size="30" style="border:solid 1px grey;"/><br>
    Your message:<br>
    <textarea name="message" rows="7" cols="30" style="border:solid 1px grey;"></textarea><br>
    <input type="submit" value="Send email"/>
    </form>
    <?php
    } 
else           
    {
    $name=$_REQUEST['name'];
    $email=$_REQUEST['email'];
    $message=$_REQUEST['message'];
    if (($name=="")||($email=="")||($message==""))
        {
        echo "All fields are required, please fill <a href=\"\">the form</a> again.";
        }
    else{        
        $from="From: $name<$email>\r\nReturn-path: $email";
        $subject="Message sent using your contact form";
        mail("youremail@yoursite.com", $subject, $message, $from);
        echo "Email sent!";
        }
    }  
?>

<?php require_once('_footer.php'); ?>