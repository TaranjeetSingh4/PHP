<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $division_id=$_GET['division_id'];
        if($division_id){
            $query="SELECT distinct(district_name),id from master_district where division_id=$division_id";
            $dis=$division_id;
            $district_result=mysqli_query($conn,$query);

            if(mysqli_num_rows($district_result)>0){
?>
                <option value="">--------Select District--------------</option>
<?php
                
                foreach($district_result as $row){
?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['district_name']; ?></option>
    <?php
                }
            }

    ?>


<?php

        }
        else{
            $query="SELECT distinct(district_name),id from master_district order by district_name";
            $district_result=mysqli_query($conn,$query);
        }

       
        
        

        
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
}

else{
    header('location:../index.php');
}


?>