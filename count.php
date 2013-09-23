<?php
        
        //$title = "信息反馈系统";
        require_once("inc/init.php");
        

        
        $result = mysql_query("SELECT * FROM depart", $conn);
        
        echo "<table border='1'>
        <tr>
        <th>DepartID:</th>
        <th>Name:</th>
        </tr>";
        
        while($row = mysql_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "</tr>";
          }
        echo "</table>";
        
        //echo date("Y/m/d");
        //echo mktime(7,16,2013);
    //  echo strtotime("16 July 2013");
//      echo "<td>" .mktime(7,16,2013). "</td>";
        
        /////////////////////////////////////////////////////
        ///////显示问题表内容////////////////////////////////
        
        $result = mysql_query("SELECT * FROM problem_time");
        
        echo "<table border='1'>
        <tr>
        <th>ID:</th>
        <th>TimeC:</th>
        <th>Time:</th>
        </tr>";
        
        while($row = mysql_fetch_array($result))
          {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['time'] . "</td>";
          echo "<td>" . date("Ymd",$row['time']) . "</td>";
          echo "</tr>";
          }
        echo "</table>";
        
        ///////////////////////////////////////////////////
        //////////////对时间戳的操作//////////////////////
    //  $arr=getdate();
    //  $year=$arr['year'];
    //  $startTime=mktime(1,1,$year);
        
    //  echo  $startTime;
        ///////////////////////////////////////////////////
        //////正式开始/////////////////////////////////////
        $result = mysql_query("SELECT * FROM depart");
        
        while($row = mysql_fetch_array($result)){
            $depart_id=$row['id'];
            $depart_name=$row['name'];
            
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>".$depart_name ."所占比例". "</th>";
            echo "<th>"."问题个数" . "</th>";
            echo "<th>"."年份" . "</th>";
            echo "</tr>";
                
            $arr = getdate();
            $year = $arr['year'];
            
            while($year>=2013){
               $startTime = mktime(0,0,0,1,1,$year); 
               $endTime = mktime(23,59,59,12,31,$year);
               //echo $startTime;
              // echo $endTime;
              // echo time();
               $sql_all = "select count(*) from problem_time where time between $startTime and $endTime";
               //$sql_all = "select count(*) from problem_time";
               
               $sumResult=mysql_query($sql_all);
               
               while($row = mysql_fetch_array($sumResult)){
                    $sum = $row[0];
                    //echo $sum;
               }
            
               $sql_single = "select count(*) from problem_time where (time between $startTime and $endTime) and pro_id in (select id from problem where depart_Id = $depart_id)";
               $singleResult = mysql_query($sql_single);
               
               while($row = mysql_fetch_array($singleResult)){
                    $single = $row[0];
                    //echo $sum;
               }
               echo "<tr>";
               echo "<td>" . (double)((double)$single/(double)$sum) . "</td>";
               echo "<td>" . $single . "</td>";
               echo "<td>" . $year . "</td>";
               echo "</tr>";
               
               $year--;   
            
            }
            
            echo "</table>";
            
        }
            
?>




 
<?php 
    include_once('inc/footer.inc.php'); 
    include_once("inc/end.php");
?>
