<?php

//fetch.php

include('database_connection.php');

if(isset($_POST["Fields"]))
{
 $query = "
 SELECT * FROM tbl_employee 
 WHERE Fields = '".$_POST["Fields"]."' 
 ORDER BY id ASC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output[] = array(
   'Physics'   => floatval($row["Physics"]),
   'Maths'  => floatval($row["Maths"]),
   'Chemistry'  => floatval($row["Chemistry"]),
   'Bio'  => floatval($row["Bio"]),
   'SST'  => floatval($row["SST"]),
  );
 }
 echo json_encode($output);
}

?>


