<?php

include "connect.php";

$data = array(1,2,3,4);
$result = shell_exec('python parseData.py $data' . escapeshellarg(json_encode($data)));
$resultData = json_decode($result, true);
var_dump($resultData);

?>