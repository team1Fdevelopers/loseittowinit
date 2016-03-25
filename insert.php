
		<?php
						
			if(!$_ENV["VCAP_SERVICES"]){ //local dev
			$mysql_server_name = "us-cdbr-iron-east-03.cleardb.net";
			$mysql_username = "b3a3d80af20f07";
			$mysql_password = "d28f1970";
			$mysql_database = "ad_78e8d4f6e5c0209";
		} else { //running in Bluemix
			$vcap_services = json_decode($_ENV["VCAP_SERVICES" ]);
			//if($vcap_services->{'mysql-5.5'}){ //if "mysql" db service is bound to this application
			//	$db = $vcap_services->{'mysql-5.5'}[0]->credentials;
			//} 
			if($vcap_services->{'cleardb'}){ //if cleardb mysql db service is bound to this application
				$db = $vcap_services->{'cleardb'}[0]->credentials;
			} 
			else { 
				echo "Error: No suitable MySQL database bound to the application. <br>";
				die();
			}
			$mysql_database = $db->name;
			$mysql_port=$db->port;
			$mysql_server_name =$db->hostname . ':' . $db->port;
			$mysql_username = $db->username; 
			$mysql_password = $db->password;
		}
		//echo "Debug: " . $mysql_server_name . " " .  $mysql_username . " " .  $mysql_password . "\n";
		$mysqli = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $mysql_database);
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			die();
		}
		
			$sql = "INSERT INTO LITWI_signups (Employer_name, Employer, infomration_source, BMI, Height_in_Inches, Current_Weight, Email)
VALUES ('$_POST[Employer_name]', '$_POST[Employer]', '$_POST[infomration_source]', '$_POST[BMI]', '$_POST[Height_in_Inches]', '$_POST[Current_Weight]', '$_POST[Email'])";

		mysqli_query($mysqli, $sql);
		$result->close();
         mysqli_close();
			
        ?>
