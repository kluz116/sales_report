<?php

     require'connect.php';


      $fromDate = $_POST['from_date'];
	  $toDate = $_POST['todate'];


      // $from = date_format(date_create($fromDate),"d/m/Y");
       //$to = date_format(date_create($toDate),"d/m/Y");

	  if (!empty($fromDate) && !empty($toDate)) {
        try{

		 $date =$db->prepare('SELECT SUM(`Total_Profit`) AS Total,`Item_Type` FROM `report` WHERE `Order_Date` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" GROUP BY Item_Type ORDER BY  SUM(`Total_Profit`) DESC LIMIT 5 ');
		 $date->execute();
         $data = array();

		 while ($row= $date->fetch(PDO::FETCH_ASSOC)) {
		 	 $Item_Type = $row['Item_Type'];
             $Total = $row['Total'];

            $data[] = array('Item_Type' => $Item_Type,'value'=>number_format($Total) );
		 }

		    echo json_encode($data);

		 	}catch(PDOException $e){

		  trigger_error('Errors :'.$e->getMessage());

	   }
	

	}




?>