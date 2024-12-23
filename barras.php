<?php

$codigo_barra="7790290000523";
$api_url = "https://apirest-lasbarricas.soemgroup.com.ar";
$method="POST";
$url=$api_url."/list_info_producto/";
$data='{"codigo_barra":"'.$_POST['code'].'"}';

$result= callAPI($method, $url, $token, $data);
$resultCode=$result[0];
if($resultCode=="200")
{
	$resultData=json_decode($result[1]);
	if($resultData==""){
	    echo "SINDATOS";
	}else{
	echo "PRODUCTO@".$resultData->nombre."@".$resultData->precio_lista."@".$resultData->precio_efectivo;
	    
	}
}


function callAPI($method, $url, $token,$data = false)
{
	
    $curl = curl_init();
	$options = array(
		CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Authorization-token:'.$token));
	curl_setopt($curl, CURLOPT_USERAGENT, "Flexmind");
	switch ($method)
	{
		case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);

			if ($data)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;
		case "PUT":
			curl_setopt($curl, CURLOPT_PUT, 1);
			break;
		default:
			if ($data)
				$url = sprintf("%s?%s", $url, http_build_query($data));
	}


	curl_setopt_array( $curl, $options );
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return array($http_code,$result);
}

?>
