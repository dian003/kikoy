<?php
function generateRandomString($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function check($code){
	$getContents = file_get_contents("http://jis.ooo/kfc/8digit.php?c=".$code);
	$jDecode = json_decode($getContents);
	if ($jDecode->status == "valid"){
		echo $code." => VALID";
	}else{
		echo $code." => INVALID";
	}
}

while (true){
	check(generateRandomString())."\n";
}

?>
