<?php
	// ����������� ���������
	require "inc/lib.inc.php";
	require "inc/config.inc.php";
	
	$id = clearInt($_GET["id"]);//���������� � $id �������������, ������� �������� ������� GET � $_GET
	if($id){
		add2Basket($id);//�������� ������� add2Basket, ��������� � ���
		header("Location: catalog.php");
		exit;
	}	//$id = ��������� ����� ���.�����, ��������� �� $_GET["id"], ������� ��������
		//� ������� add2Basket($id)
?>