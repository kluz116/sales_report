<?php
	try {
	  $db = new PDO("mysql:host=localhost;dbname=sales_report", 'root','Python@2019');
	  if ($db) {
	  	//echo "connected";
	  }
	}
	catch(PDOException $e) {
	    echo $e;
	}
