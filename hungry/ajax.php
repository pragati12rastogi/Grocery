<?php 

require 'include/dbconfig.php';

$productName = $_POST['value1'];

$c = $con->query("select * from product where pname like '%$productName%'");
while($row = $c->fetch_assoc()){
	echo $productName = $row['pname'];
}