<?php 

include('../class/Controller.php');
$obj=new Controller();


if(isset($_POST['name'])){
 $obj->edit_admin($_POST);


}




 ?>