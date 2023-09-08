<?php
$receive_post = $_SERVER["REQUEST_URI"];
$tag = $_POST['tag'];
$file = 'tinywebdb.html';

if(strpos($receive_post,'storeavalue')){
	$value = $_POST['value'];
	include "connection.php";
	$strSQL = "INSERT INTO Tags (Id,Tag,Conteudo) ";
	$strSQL .= " VALUES (null,'" . $tag . "','" . $value . "')";
	$conn->exec($strSQL);
	include "connection_close.php";
	$result = array("VALUE", $value, "Gravado");
	echo json_encode($result);
	} else {
	/////
	// GET VALUE de TAG.
	// Search no file tinywebdb.html pela tag.
	$exist = ""; 
	include "connection.php";
	$strSQL = "SELECT * FROM Tags WHERE Tag = '" .  $tag . "'";
	$comm = $conn->prepare($strSQL);
	$comm->execute();
	$row = $comm->fetch();
	$CAMPOS = $row;	
	$value = $row["Conteudo"];
	if( $value != null ){ $exist = true; };
	// Fecha o arquivo	
	include "connection_close.php";
	// Envia o result de acordo com a detecção de existência ou não da tag
	if ($exist){ $result = array("VALUE", $tag, $value);}    // Envia value
	else { $result = array("VALUE", $tag, "Not_found");}  // Envia "Not_found".
	// Resultado
	$result_in_JSON = json_encode($result);
	echo $result_in_JSON;
	}


?>