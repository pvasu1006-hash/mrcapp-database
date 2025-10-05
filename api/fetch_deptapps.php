<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    if ($conn) {

        $query = "SELECT * FROM deptapps";

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
