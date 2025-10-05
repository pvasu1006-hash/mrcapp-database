<?php
try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    if ($conn) {
       
    //    $query = "SELECT * FROM whatsapp_groups";

       $query =    "SELECT a.id, a.group_name, a.group_icon, p.tot_posts FROM whatsapp_groups a
LEFT JOIN(
SELECT b.group_id, sum(b.status) as tot_posts FROM posts b 
JOIN whatsapp_groups a1 ON a1.id = b.group_id 
GROUP BY a1.id
)p ON p.group_id = a.id";




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

