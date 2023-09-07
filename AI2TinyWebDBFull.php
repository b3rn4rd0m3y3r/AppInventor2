<?php
$receive_post = $_SERVER["REQUEST_URI"];
$tag = $_POST['tag'];
$file = 'tinywebdb.html';


if(strpos($receive_post,'storeavalue')){
	// If exist that tag, DELETE it
	// to avoid repeating that tag.
	$arq = file($file);
	$pt = fopen($file,"w");
	foreach($arq as $line)	{ 
		$fields = explode(":", $line);
		if ($fields[0] != $tag) { fputs($pt, $line); }
		}
	// Fecha o arquivo
	fclose($pt);
	// Grava TAG e VALUE
	$value = $_POST['value'];
	$line = $tag . ":" . $value . ":\n";
	$pt= fopen($file, 'a'); // Add $line ao tinywebdb.html
	fwrite($pt, $line);
	// Fecha o arquivo
	fclose($pt);	
	$result = array("VALUE", $value, "Gravado");
	echo json_encode($result);
	} else {
	/////
	// GET VALUE de TAG.
	// Search no file tinywebdb.html pela tag.
	$pt = fopen($file, 'r');
	$exist = ""; 
	// Loop de leitura linha/linha do banco de dados
	while( !feof($pt) && $exist == "" ){
	    $lin = fgets($pt);
	    $fields = explode(":", $lin);
	    if ($fields[0] == $tag) {
			$value =$fields[1];
			$exist = true;
			}
		}
	// Fecha o arquivo	
	fclose($pt);
	// Envia o result de acordo com a detecção de existência ou não da tag
	if ($exist){ $result = array("VALUE", $tag, $value);}    // Envia value
	else { $result = array("VALUE", $tag, "Not_found");}  // Envia "Not_found".
	 
	$result_in_JSON = json_encode($result);
	echo $result_in_JSON;
	}


?>