<?php
$receive_post = $_SERVER["REQUEST_URI"];
$tag = $_POST['tag'];
$file = 'tinywebdb.html';
// GRAVAÇÃO
if(strpos($receive_post,'storeavalue')){
	$value = $_POST['value'];
	$value = str_replace("\"", "", $value);
	$pieces = explode(":", $value);
	$vCod = $pieces[0];
	$vNome = $pieces[1];
	$vTelefone = $pieces[2];
	include "connection.php";
	$strSQL = "INSERT INTO Contatos (Id,Tag, Cod, Nome, Telefone) ";
	$strSQL .= " VALUES (null,'" . $tag . "','" . $vCod . "','" . $vNome . "','" . $vTelefone . "')";
	$conn->exec($strSQL);
	include "connection_close.php";
	$result = array("VALUE", $value, "Gravado");
	echo json_encode($result);
	} else {
	/////
	// LEITURA de TAG.
	// Search no file tinywebdb.html pela tag.
	$exist = ""; 
	include "connection.php";
	$strSQL = "SELECT * FROM Contatos WHERE Tag = '" .  $tag . "'";
	$comm = $conn->prepare($strSQL);
	$comm->execute();
	$row = $comm->fetch();
	$CAMPOS = $row;	
	// Monta o conteúdo para o TinyDB
	$value = $row["Cod"] . ":" . $row["Nome"] . ":" . $row["Telefone"] ;
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