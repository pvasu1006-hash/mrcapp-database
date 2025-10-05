<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    $data = json_decode(file_get_contents("php://input"));
    $id = (isset($data->id) ? $data->id : false);
    // $id = 2;

    if ($conn) {
       
       $query = "SELECT * FROM whatsapp_groups WHERE id = $id LIMIT 1";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $res = [];

        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            $res = $row;
        }

        $array = array(
            "msg" => "Status OK",
            "data" => $res
        );

        echo json_encode($array, JSON_PRETTY_PRINT);
    } else {
        echo "something went wrong";
    }

    /* close connection */
    $conn = null;
} catch (PDOException $e) {
    echo $e->getMessage();
}


