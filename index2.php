
<?php  

//index.php

include("database_connection.php");

$query = "SELECT Fields FROM tbl_employee GROUP BY Fields DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

?>  
<!DOCTYPE html>  
<html>  
    <head>  
        <title>CHARTS WITH GOOGLE CHARTS</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
                  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  

        <link href='https://fonts.googleapis.com/css?family=Forum' rel='stylesheet'>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<link rel="stylesheet" href="{% static 'styles.css' %}">
    </head>  




    <body> 
        <br /><br />
        <div class="wrapper ">  
            <h3 align="center">Google Charts</h3>  
            <br />  
            
            <div class="panel panel-default bg-dark">
                <div class="panel-heading ">
                    <div class="row">
                        <div class="col-md-9 ">
                            <h3 class="panel-title">Marks Wise Data</h3>
                        </div>
                        <div class="col-md-3">
                            <select name="Fields" class="form-control" id="Fields">
                                <option value="">Select Fields</option>
                            <?php
                            foreach($result as $row)
                            {
                                echo '<option value="'.$row["Fields"].'">'.$row["Fields"].'</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_area"  style="align:center; height: 620px;"></div>
                </div>
            </div>
        </div>  
    </body>  
</html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback();

function load_markswise_data(Fields, title)
{
    var temp_title = title + ' '+Fields+'';
    $.ajax({
        url:"fetch.php",
        method:"POST",
        data:{Fields:Fields},
        dataType:"JSON",
        success:function(data)
        {
            drawMarkswiseChart(data, temp_title);
        }
    });
}

function drawMarkswiseChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Physics');
    data.addColumn('number', 'Maths');
    data.addColumn('number', 'Chemistry');
    data.addColumn('number', 'Bio');
    data.addColumn('number', 'SST');
    $.each(jsonData, function(i, jsonData){
        var Physics = parseFloat($.trim(jsonData.Physics));
        var Maths = parseFloat($.trim(jsonData.Maths));
        var Chemistry = parseFloat($.trim(jsonData.Chemistry));
        var Bio = parseFloat($.trim(jsonData.Bio));
        var SST = parseFloat($.trim(jsonData.SST));
        data.addRows([[Physics, Maths ,Chemistry, Bio, SST]]);
    });
    var options = {
        title:chart_main_title,
        hAxis: {
            title: "Physics"
        },
        vAxis: {
            title:"Fields"
        },

    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
    chart.draw(data, options);
}

</script>

<script>
    
$(document).ready(function(){

    $('#Fields').change(function(){
        var Fields = $(this).val();
        if(Fields != '')
        {
            load_markswise_data(Fields, 'Marks Wise Data For');
        }
    });

});

</script>