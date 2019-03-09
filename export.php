 <?php  
 if(!empty($_FILES["employee_file"]["name"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "testing");  
      $output = '';  
      $allowed_ext = array("csv");  
      $tmp = explode(".", $_FILES["employee_file"]["name"]); 
      $extension = end($tmp);
      if(in_array($extension, $allowed_ext))  
      {  
           $file_data = fopen($_FILES["employee_file"]["tmp_name"], 'r');  
           fgetcsv($file_data);  
           while($row = fgetcsv($file_data))  
           {  
                $Fields = mysqli_real_escape_string($connect, $row[0]);  
                $Physics = mysqli_real_escape_string($connect, $row[1]);  
                $Maths = mysqli_real_escape_string($connect, $row[2]);  
                $Chemistry = mysqli_real_escape_string($connect, $row[3]);  
                $Bio = mysqli_real_escape_string($connect, $row[4]); 
                $SST = mysqli_real_escape_string($connect, $row[5]); 
                $query = "  
                INSERT INTO tbl_employee  
                     (Fields, Physics, Maths, Chemistry, Bio, SST)  
                     VALUES ('$Fields', '$Physics', '$Maths', '$Chemistry', '$Bio' ,'$SST')  
                ";  
                mysqli_query($connect, $query);  
           }  
           $select = "SELECT * FROM tbl_employee ORDER BY id DESC";  
           $result = mysqli_query($connect, $select); 
           $output .= '  
                <table class="table table-bordered">  
                     <tr>  
                          <th width="5%">ID</th>  
                          <th width="25%">Fields</th>  
                          <th width="35%">Physics</th>  
                          <th width="10%">Maths</th>  
                          <th width="20%">Chemistry</th>  
                          <th width="5%">Bio</th>  
                          <th width="5%">SST</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr>  
                          <td>'.$row["id"].'</td>  
                          <td>'.$row["Fields"].'</td>  
                          <td>'.$row["Physics"].'</td>  
                          <td>'.$row["Maths"].'</td>  
                          <td>'.$row["Chemistry"].'</td>  
                          <td>'.$row["Bio"].'</td>  
                          <td>'.$row["SST"].'</td> 
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
           echo $output;  
      }  
      else  
      {  
           echo 'Error1';  
      }  
 }  
 else  
 {  
      echo "Error2";  
 }  
 ?>  