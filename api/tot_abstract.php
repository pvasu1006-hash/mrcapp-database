<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    if ($conn) {
       
       $query = "SELECT count(s.id) as tot_schools,
       (SELECT count(t.udise) FROM teachers_master t ) as tot_teachers,
       (SELECT sum(c.tot_students) FROM student_enrollment c ) as tot_students  
       FROM school_master s WHERE s.status = 'Active'";

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


