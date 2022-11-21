<?php
$json = file_get_contents('app.json');
$array = json_decode($json, true);
$array["frames"][0]["icon"] = 7660;
$array["frames"][0]["text"] = date("H:i", time());
file_put_contents("app.json",json_encode($array),LOCK_EX);
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header('Location: https://yoshi-web-store.com/lametric/app.json?'.time());
exit();
?>