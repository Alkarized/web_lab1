<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(400);
    exit;
}
header("Content-Type: text/html");
$x = $_GET["xVar"];
$y = $_GET["yVar"];
$r = $_GET["rVar"];
$date = date("H:i:s D M Y");
$start_time = microtime(true);
$is_hit = "";
$array = [];

if (!isset($_SESSION["request"])) {
    $_SESSION["request"] = [];
}

if (!(is_numeric($x) && $x > -3 && $x < 5)
    || !(is_numeric($y) && $y >= -5 && $y <= 3)
    || !(is_numeric($r) && $r <= 3 && $r >= 1)) {
    http_response_code(400);
    //header("Status: 400");
    exit;
} else {
    $x = substr($x, 0, 10);
}

if (($y <= 0 && $x <= 0 && abs($x) <= $r && abs($y) <= $r) ||
    (abs($y) <= $r && $x <= $r && $y <= 0 && $x >= 0 && $x <= sqrt(pow($r, 2) - pow($y, 2))) ||
    (abs($x) <= 0 && $y >= 0 && $x <= $r / 2 && $y <= $r && $y <= 2 * $x + $r) || ($x == 0 && $y == 0)) {
    $is_hit = "true";
} else {
    $is_hit = "false";
}

//$array = array("x"=> $x, "y"=> $y, "r" => $r, "hit" => $is_hit, "date" => $date,
//    "time" => number_format(microtime(true) - $start_time, 6, ",", ""));

$array = array($x, $y, $r, $is_hit, $date, number_format(microtime(true) - $start_time, 6, ",", ""));
array_push($_SESSION["request"], $array);
/*$json = json_encode($_SESSION["request"]);
echo $json;*/
$table = "";

foreach ($_SESSION['request'] as $resp) {
    $table .= "<tr class = 'response_table_values'>";
    $table .= "<td>" . $resp[0] . "</td>";
    $table .= "<td>" . $resp[1] . "</td>";
    $table .= "<td>" . $resp[2] . "</td>";
    if ($resp[3] === "true") {
        $table .= "<td class = 'response_table_value_hit_true'>" . "Попало" . "</td>";
    } else {
        $table .= "<td class = 'response_table_value_hit_false'>" . "Не попало" . "</td>";
    }
    $table .= "<td>" . $resp[4] . "</td>";
    $table .= "<td>" . $resp[5] . "</td>";
    $table .= "</tr>";
}

//echo $table;
//$itog = "";
/*foreach ($_SESSION['request'] as $resp) {
$jsonData = '{' .
"\"x\":\"$resp[0]\"," .
"\"y\":\"$resp[1]\"," .
"\"r\":\"$resp[2]\"," .
"\"hit\": \"$resp[3]\"," .
"\"date\":\"$resp[4]\"," .
"\"time\":\"$resp[5]\"" .
"}";
$itog = $itog . $jsonData . ',';

}
$itog = substr($itog, 0, -1);
echo "[" . $itog . ']';*/
?>
<html>
<head>

</head>
<body>
<table id="response_table">
    <tr>
        <th>Значение X</th>
        <th>Значение Y</th>
        <th>Значение R</th>
        <th>Факт попадания</th>
        <th>Текущее время</th>
        <th>Время выполнения (в мс)</th>
    </tr>
    <?php echo $table ?>
</table>
</body>
</html>



