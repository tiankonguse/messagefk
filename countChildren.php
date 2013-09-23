<?php
        
        //$title = "信息反馈系统";
        //require_once("inc/init.php");
        
        ini_set('date.timezone','Asia/Shanghai');
        date_default_timezone_set('Asia/Shanghai');
        
        $con = mysql_connect("localhost","root","");
        
        if (!$con){
            die('Could not connect: ' . mysql_error());
        }
        mysql_query("set names gbk");
        
        mysql_select_db("tiankong_mfk", $con);
        
        $result = mysql_query("SELECT id,name FROM depart");
        /*
        echo "<table border='1'>
        <tr>
        <th>DepartID:</th>
        <th>Name:</th>
        </tr>";
        */
        while($row = mysql_fetch_array($result)){
        
             echo "<table border='1'>";
             echo "<tr>";
             echo "<th>"."子模块名称". "</th>";
             echo "<th>"."所占比例". "</th>";
             echo "<th>"."问题个数" . "</th>";
             echo "<th>"."年份" . "</th>";
             echo "</tr>";  
             echo "<h1>".$row['name']."项目统计信息"."</h1>";
             
             $depart_id=$row['id'];
             
             $arr = getdate();
             $year = $arr['year'];
            
             while($year>=2013){
             
                $startTime = mktime(0,0,0,1,1,$year); 
                $endTime = mktime(23,59,59,12,31,$year);
             
                $sqlBlock="select * from block where id in (select block_id from map_block_depart where depart_id = $depart_id)";
                
                $sql_All = "select count(*) from problem_time where (time between $startTime and $endTime) and pro_id in (select id from problem where depart_Id = $depart_id)";
                $sumResult=mysql_query($sql_All);
               
                while($row = mysql_fetch_array($sumResult)){
                    $sum = $row[0];
                    //echo $sum;
               }
                $resultBlock=mysql_query($sqlBlock);
                
                while($row = mysql_fetch_array($resultBlock)){
                    $block_id = $row['id'];
                    $block_name = $row['name'];
                    //echo $blok_id .$block_name ;
                    $sql_single = "select count(*) from problem_time where (time between $startTime and $endTime) and pro_id in (select id from problem where block_id = $block_id)";
                    
                    $singleResult = mysql_query($sql_single);
                    
                    while($row = mysql_fetch_array($singleResult)){
                         $single= $row[0];
                         //echo $single;
                    }
                    if($sum==0){
                        $per=0;
                    }else{
                        $per=(double)$single/(double)$sum;
                    }
                    
                    echo "<tr>";
                    echo "<td>" .$block_name . "</td>";
                    echo "<td>" .$per . "</td>";
                    echo "<td>" . $single . "</td>";
                    echo "<td>" . $year . "</td>";
                    echo "</tr>";
                    
                }
                echo "</table>";
                $year--;
            }
                         
             
             
        }
        
?>