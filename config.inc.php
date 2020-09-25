<?php
require'connection.php';
session_start();


class Config extends Connection
{


public function loginUser()
{
	if(isset($_POST['email']) && isset($_POST['password'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (!empty($email) && !empty($password)) {
			try{

		    $data =$this->dbh-> prepare('select * from users where password=:password and email=:email');
			$data->bindParam(':email',$email);
			$data->bindParam(':password',$password);
			$data->execute();

			$row = $data->fetch(PDO::FETCH_ASSOC);

			if($row){
				         $_SESSION['email'] = $email;
						if(isset($_SESSION['email'])){

                             header("Location:index.php");
                             exit();
						}else{
							 header("Location:login.php");
						}
			}else{
				echo "You Not Authorised To Login, Contact system administrator";
			}

			}catch(PDOException $e){
				trigger_error('Error: ' .$e->getMessage());
			}

		}else{

			echo "Fill In All Fields.";
		}
	}
}


public function getSessionInfo()
{
	try {
        if($_SESSION['email']){
        $email = $_SESSION['email'];

        $data =$this->dbh-> prepare('select * from users where email=:email');
        $data->bindParam(':email',$email);
        $results= $data->execute();

        while ($row= $data->fetch(PDO::FETCH_ASSOC)) {

            $user_name = $row['user_name'];
		      echo $user_name;

           }


          }



} catch (PDOException $e) {

     }
}


public function UploadCsv()
{
	if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){

                // Get row data
                $Region   = $line[0];
                $Country  = $line[1];
                $Item_Type  = $line[2];
                $Sales_Channel = $line[3];
                $Order_Priority = $line[4];	
                $Order_Date = date_format(date_create($line[5]),"Y-m-d");
                $Order_ID = $line[6];	
                $Ship_Date = date_format(date_create($line[7]),"Y-m-d");	
                $Units_Sold	= $line[8];
                $Unit_Price	= $line[9];
                $Unit_Cost = $line[10];
                $Total_Revenue = $line[11];	
                $Total_Cost = $line[12];	
                $Total_Profit = $line[13];


                try{
			
				$query = "INSERT INTO report(Region, Country, Item_Type, Sales_Channel, Order_Priority, Order_Date, Order_ID, Ship_Date, Units_Sold, Units_Price, Unit_Cost, Total_Revenue, Total_Cost, Total_Profit) VALUES 
				(:Region,:Country, :Item_Type, :Sales_Channel, :Order_Priority, :Order_Date, :Order_ID, :Ship_Date, 
				:Units_Sold, :Unit_Price, :Unit_Cost, :Total_Revenue, :Total_Cost, :Total_Profit)";
			    $data = $this->dbh->prepare($query);

                $data->bindParam(':Region',$Region);
				$data->bindParam(':Country',$Country);
				$data->bindParam(':Item_Type',$Item_Type);
				$data->bindParam(':Sales_Channel',$Sales_Channel);
				$data->bindParam(':Order_Priority',$Order_Priority);
				$data->bindParam(':Order_Date',$Order_Date);
				$data->bindParam(':Order_ID',$Order_ID);
				$data->bindParam(':Ship_Date',$Ship_Date);
				$data->bindParam(':Units_Sold',$Units_Sold);
				$data->bindParam(':Unit_Price',$Unit_Price);
				$data->bindParam(':Unit_Cost',$Unit_Cost);
				$data->bindParam(':Total_Revenue',$Total_Revenue);
				$data->bindParam(':Total_Cost',$Total_Cost);
				$data->bindParam(':Total_Profit',$Total_Profit);
			     
				$res = $data->execute();
				if ($res) {
					// Redirect to the listing page
                   //header("Location: upload_file.php");
				    
				}else{
					echo "Not saved";
				}
	
	
			}catch(PDOException $e){
				
				echo "string".$e->getMessage();
			
			}

                
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
        }else{
            
        }
    }else{
        
    }
}


}

public function totalProfit()
{ 
	  $fromDate = $_POST['from_date'];
	  $toDate = $_POST['to_date'];

	  if (!empty($fromDate) && !empty($toDate)) {
        try{

		 $date =$this->dbh->prepare('SELECT SUM(Total_Profit) AS Total FROM `report` WHERE `Order_Date` BETWEEN "'.$fromDate.'" AND "'.$toDate.'"');
		 $date->execute();

		 while ($row= $date->fetch(PDO::FETCH_ASSOC)) {
		 	$Total = $row['Total'];
		 	 echo $Total;
		 }

		 	}catch(PDOException $e){

		trigger_error('Errors :'.$e->getMessage());

	   }
	

	}

}




public function getReport()
{
	try{
		 $date =$this->dbh->prepare('SELECT  Order_Date, Order_Priority, Units_Sold, Units_Price,Total_Revenue, Total_Cost, Item_Type FROM report limit 3000 ');
		 $date->execute();

		 echo "<table id='data-table-default' class='table table-bordered table-striped'>";
		 echo "<thead>";
		 echo"<tr>";
		 echo "<th>Order Date</th>";
		 echo "<th>Order Priority</th>";
		 echo "<th>Units Sold</th>";
		 echo "<th>Units_Price</th>";
		 echo "<th>Total Revenue</th>";
		 echo "<th>Total_Cost</th>";
		 echo "<th>Item Type</th>";
		 echo "</tr>";
		 echo "</thead>";
		 echo "<tbody>";
		 while ($row= $date->fetch(PDO::FETCH_ASSOC)) {

		 	
		 	$Order_Date = $row['Order_Date'];
		 	$Order_Priority = $row['Order_Priority'];
		 	$Units_Sold = $row['Units_Sold'];
		 	$Units_Price = $row['Units_Price'];
		 	$Total_Revenue = $row['Total_Revenue'];
		 	$Total_Cost = $row['Total_Cost'];
		 	$Item_Type = $row['Item_Type'];

		 	echo "<tr>";
		 	echo "<td>$Order_Date</td>";
		 	echo "<td>$Order_Priority</td>";
		 	echo "<td>$Units_Sold</td>";
		 	echo "<td>$Units_Price</td>";
		 	echo "<td>$Total_Revenue</td>";
		 	echo "<td>$Total_Cost</td>";
		 	echo "<td>$Item_Type</td>";
		 
		
		 	echo "</tr>";
		 }
		 echo "</tbody>";
		 echo "</table>";


	}catch(PDOException $e){

		trigger_error('Errors :'.$e->getMessage());

	}
}






}//End of the class.






?>
