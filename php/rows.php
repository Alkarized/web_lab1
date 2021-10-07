<?php
session_start();
if (isset($_SESSION["request"])) {
    //echo json_encode($_SESSION["request"]);
    /*$itog = "";
    foreach ($_SESSION['request'] as $resp) {
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
}

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

