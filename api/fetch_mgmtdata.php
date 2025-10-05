<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    $data = json_decode(file_get_contents("php://input"));
    $id = (isset($data->id) ? $data->id : false);
    // $id = 2;

    if ($conn) {

        $query = "SELECT sm.id, sm.udise, sm.sch_name, st.tot_students, tt.tot_teachers FROM school_master sm 
        LEFT JOIN ( SELECT se.udise, tot_students FROM student_enrollment se JOIN school_master a1 ON a1.udise = se.udise   ) st ON st.udise = sm.udise
        LEFT JOIN ( SELECT tm.udise, count(tm.udise) as tot_teachers FROM teachers_master tm JOIN school_master a1 ON a1.udise = tm.udise GROUP BY tm.udise   ) tt ON tt.udise = sm.udise
        
        WHERE sm.status = 'Active' AND sm.sch_mgmt LIKE '%$id%'";

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

    /* close connection */
    $conn = null;
} catch (PDOException $e) {
    echo $e->getMessage();
}
