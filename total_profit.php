<?php

require'connect.php';


      $fromDate = $_POST['from_date'];
	  $toDate = $_POST['todate'];


      
       //echo  $from = date_format(date_create($fromDate),"d/m/Y");
       //echo $to = date_format(date_create($toDate),"d/m/Y");



	  if (!empty($fromDate) && !empty($toDate)) {
        try{

		 $date =$db->prepare('SELECT SUM(Total_Profit) AS Total FROM `report` WHERE `Order_Date` BETWEEN "'.$fromDate.'" AND "'.$toDate.'"');
		 $date->execute();

		 while ($row= $date->fetch(PDO::FETCH_ASSOC)) {
		 	$Total = $row['Total'];
		 	 echo  number_format($Total);
		 }

		 	}catch(PDOException $e){

		  trigger_error('Errors :'.$e->getMessage());

	   }
	

	}




?>