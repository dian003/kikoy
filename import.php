<?php 
/*
  CODE BY : J3F CODE - J3F LAB - ERLANGGA LAB - ZOLDYK
  DATE EDIT : 12 / 1 / 2017
  DONT EDIT ANYTHING IF YOU DON'T KNOW ABOUT SCRIPT



  ERLANGGA ITU GANTENG
*/
$db = new mysqli("localhost","root","","panel");
$file = "service.json";
$api = "1";
$type = "Default";

$filec = json_decode(file_get_contents($file));

$temp = "";
function cat($string){
	if(strpos($string, "Instagram") !== false){
		return "1";
	}
	if(strpos($string, "Youtube") !== false){
		return "3";
	}
	if(strpos($string, "Facebook") !== false){
		return "4";
	}
	if(strpos($string, "Twitter") !== false){
		return "5";
	}
	if(strpos($string, "Pinterest") !== false){
		return "6";
	}
	if(strpos($string, "Linkedin") !== false){
		return "7";
	}
	if(strpos($string, "Traffic") !== false){
		return "8";
	}
	return "Undefined";
}

function check($id){
	global $db;
	$q = $db->query("SELECT * FROM service WHERE pro_id = '$id'");
	if($q->num_rows == "1"){
		return true;
	} 
	return false;
}
function update($id,$cat_id,$name,$price,$min,$max,$type){
	global $db;
	$q = $db->query("UPDATE service SET name = '$name',category_id = '$cat_id',
		price = '$price', min = '$min', max = '$max' , type = '$type' WHERE pro_id = '$id'");
}
function insert($id,$cat_id,$name,$price,$min,$max,$type){
	global $db;
	$q = $db->query("INSERT INTO service VALUES('','1','$cat_id','$id','$name','','$price','$min','$max','$type','0')");
}
$count_all = 0;
$count_updated = 0;
$count_insert =  0;
foreach ($filec as $key) {
	$id = $key->ID;
	$name =  rem_uknown($key->Service);
	$min = $key->min;
	$max = $key->max;
	$cat = cat($name);
	if($cat == "Undefined"){
		continue;
	}
	$count_all++;
	$price = $key->rate/1000 * 20000;
	$av = "No";
	if(check($id)){
		$av = "Yes";
		$count_updated++;
		update($id,$cat,$name,$price,$min,$max,"Default");
	} else {
		insert($id,$cat,$name,$price,$min,$max,"Default");
		$count_insert++;
	}
	$temp .= "
	ID Service : {$id} <br> 
	Service Name : {$name} <br>  
	Category : {$cat} <br> 
	Available : {$av} <br>
	Minimal Order : {$min} <br> 
	Maximal Order : {$max}<br> 
	Price : Rp.".number_format($price)." <br>
	===============================<br>";
}
function rem_uknown($string){
	$find = array("â ","â¡ï¸ ");
	$change = array("","");
	return str_replace($find, $change, $string);
}


echo "Information <br> 
==================================  <br>
Total Service : ".count($filec)." <br> 
Total Service Detected : {$count_all}<br>
Total New Service : {$count_insert} <br>
Total Updated Service : {$count_updated}<br>
==================================<br><br>Service Information ... <br>
$temp";
?>

