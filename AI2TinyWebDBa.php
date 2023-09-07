<?php
$request = $_SERVER["REQUEST_URI"];
$tag = $_POST["tag"];
$file = "tinywebdb.html";
// Testa se a requisição vem do método storevalue
if( strpos($request,"storeavalue") ){

	$valor = $_POST["value"];
	$pt = fopen($file, "a");
	$lin = $tag . ":" . $valor . ":\n";
	fwrite($pt, $lin);
	fclose($pt);
	} else {
	$pt = fopen($file, "r");
	$existe = "";
	while( !feof($pt) ){
		$lin = fgets($pt);
		$fields = explode(":",$lin);
		if( $fields[0] == $tag ){
			$value = $fields[1];
			$existe = true;
			}
		}
	fclose($pt);
	$result = array("VALUE", $tag, "Não existe");
	if( $existe ){
		$result = array("VALUE", $tag, $value);
		}
	echo json_encode($result);
	}
?>