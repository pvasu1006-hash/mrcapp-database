<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    $data = json_decode(file_get_contents("php://input"));
    $id = (isset($data->id) ? $data->id : false);
    // $id = 2;

    if ($conn) {

        $query = "SELECT a.sch_name, a.rf_released, a.rf_expenditure, a.tot_bal, b.mbnn_sanctioned, b.no_acrs, sch_type 
        FROM rep_3_4_rf a LEFT JOIN mbnn2_fin b ON b.sch_name = a.sch_name 
        WHERE b.sch_type NOT IN ('AWC') 
        ORDER BY a.tot_bal DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $res = [];

        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            $res = $row;
        }

        // $array = array(
        //     "msg" => "Status OK",
        //     "data" => $res
        // );

        echo json_encode($res, JSON_PRETTY_PRINT);
    } else {
        echo "something went wrong";
    }

    /* close connection */
    $conn = null;
} catch (PDOException $e) {
    echo $e->getMessage();
}
