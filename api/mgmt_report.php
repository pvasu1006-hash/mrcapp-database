<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    if ($conn) {
        $mgmt = 'STATE GOVT.';


        $query = "SELECT  m.sch_name, m.udise,  t.tot_teachers, c.tot_childs FROM school_master m

     
                    LEFT JOIN (SELECT tm.udise, count(tm.udise) as tot_teachers FROM teachers_master tm
                            GROUP by tm.udise
                    ) t ON  m.udise = t.udise
       
        LEFT JOIN (SELECT cm.udise, cm.tot_students as tot_childs FROM student_enrollment cm
       JOIN school_master s ON s.udise = cm.udise
       ) c ON m.udise = c.udise       
               
      WHERE m.status = 'Active' AND m.sch_mgmt = '$mgmt'
      ORDER by m.sch_name ASC
      ";

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
