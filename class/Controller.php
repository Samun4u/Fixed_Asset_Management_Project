<?php
session_start();
require('Database.php');
class Controller extends Database
{
	public function login($data)
	{
		$result=$this->db->query('select * from admin where email="'.$data['email'].'" and password="'.$data['password'].'"');
		$d= $result->fetch(PDO::FETCH_ASSOC);
		if($d){
			$_SESSION['adminID']=$d['id'];
			$_SESSION['name']=$d['name'];
			header('Location: dashboard.php');
		}else{
			$_SESSION['msg']='Wrong email or password';
			header('Location: index.php');
		}
	}
	public function logout()
	{
		session_destroy();
		header('Location: index.php');
	}
	public function is_logged_in()
	{
		if(!isset($_SESSION['adminID'])){
			header('Location: index.php');
		}
	}
	public function new_product($data)
	{
		$target_dir = "../upload/";
		$target_file = $target_dir . basename($_FILES["photo"]["name"]);
		move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
		$data['photo']=$_FILES["photo"]["name"];
		$this->insert('product',$data);
		header('Location: product_list.php');
	}
	public function new_admin($data)
	{
		$this->insert('admin',$data);
		header('Location: admin_list.php');
	}
	public function get_admin(){
		$admins=$this->getData('admin','1');
		return $admins;
	}
	public function del_admin($id)
	{
		$this->delete('admin',' id= '.$id);	
	}
	public function edit_admin($data)
	{
		$this->update('admin',$data,'id='.$data['id']);
		header("Location:user.php"); 
	}
	public function get_product()
	{
		$result=$this->getData('product','1 order by id desc');
		return $result;
	}
	public function del_product($id)
	{
		$this->delete('product',' id= '.$id);
	} 
	public function edit_product($data)
	{
		$this->update('product',$data,'id='.$data['id']);
		header('Location: product_list.php');
	}
	public function get_for_update($id)
	{
		$d=$this->getData('product','id='.$id);
		return $d->fetch(PDO::FETCH_ASSOC);
	} 
	
	
}