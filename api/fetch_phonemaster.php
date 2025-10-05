<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    $data = json_decode(file_get_contents("php://input"));

    // $id = (isset($data->id) ? $data->id : false);

    if ($conn) {

        $query = "SELECT * FROM phone_master";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $res = [];

        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            $res = $row;
        }


        echo json_encode($res, JSON_PRETTY_PRINT);
    } else {
        echo "something went wrong";
    }

   
    $conn = null;
} catch (PDOException $e) {
    echo $e->getMessage();
}
