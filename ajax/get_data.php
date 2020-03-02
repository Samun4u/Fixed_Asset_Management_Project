<?php 

$v=$_POST['n1']+$_POST['n2'];
echo json_encode(array('results'=>$v,'status'=>'Done','n1'=>$_POST['n1'],'n2'=>$_POST['n2']));
