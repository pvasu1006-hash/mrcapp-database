<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    if ($conn) {
       
       $query = "SELECT m.id, m.sch_mgmt, s.tot_schools, t.tot_teachers, c.tot_childs FROM mgmt_master m

        LEFT JOIN (SELECT sm.sch_mgmt, count(sm.sch_mgmt) as tot_schools FROM school_master sm
        WHERE sm.status = 'Active'
        GROUP BY sm.sch_mgmt
        ) s ON m.sch_mgmt = s.sch_mgmt

        LEFT JOIN (SELECT s.udise, s.sch_mgmt, count(tm.udise) as tot_teachers FROM teachers_master tm
        JOIN school_master s ON s.udise = tm.udise
        GROUP BY s.sch_mgmt
        ) t ON  m.sch_mgmt = t.sch_mgmt
        
        LEFT JOIN (SELECT s.udise, s.sch_mgmt, sum(cm.tot_students) as tot_childs FROM student_enrollment cm
        JOIN school_master s ON s.udise = cm.udise
        GROUP BY s.sch_mgmt
        ) c ON  m.sch_mgmt = c.sch_mgmt       
                
        ORDER BY m.id ASC ";

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

