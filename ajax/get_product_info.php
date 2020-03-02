<?php
$productID=$_POST['productID'];
$info['name']='';
$info['price']='';
$file=fopen('product.csv', 'r');
while ($data=fgetcsv($file)) {
	if($data[2]==$productID){
		$info['name']=$data[0];
		$info['price']=$data[1];
	}
}

echo json_encode($info);
?>