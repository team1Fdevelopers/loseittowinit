<!DOCTYPE html>
<html>
<head>
	<title>BUDT758N - Lose It to Win It - Trial Run</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<table>
	
		<tr>
			<td style='width: 30%;'>
			<img class = 'newappIcon' src='images/loseittowinit_img.PNG'> <br><br><br>
			<img class = 'newappIcon' src='images/color-smithlogo.png'> <br>
			</td>
			<td >				
				 <br>				
				<h1 id = "message">Hello People!</h1>
				<p class='description'></p> Welcome to a FUN run of  <span class="blue">IBM BlueMix</span>. <br> BUDT758N & Lose It To Win It FTW!
				<br><br> Here's a Dilbert Comic: <br> <br>
			<img src='images/dilbert.png'>
			<br><br>
			</td>
		</tr>
	</table>
	
 <div class="">
        <p class="description">Here's a sample  <span class="blue">Lose it to win it</span> database output on Bluemix!
    
    <table id='notes' class='records'><tbody>
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

			$sql = "select EMPLOYER_NAME, EMPLOYER, INFOMRATION_SOURCE, BMI, HEIGHT_IN_INCHES, CURRENT_WEIGHT, EMAIL  from LITWI_signups";
			$result = mysqli_query($mysqli, $sql);

            echo "<tr>\n";
            while ($property = mysqli_fetch_field($result)) {
                    echo '<th>' .  $property->name . "</th>\n"; //the headings
            }
            echo "</tr>\n";
            mysqli_data_seek ( $result, 0 );
            if($result->num_rows == 0){ //nothing in the table
                        echo '<td>Empty!</td>';
            }
                
            while ( $row = mysqli_fetch_row ( $result ) ) {
                echo "<tr>\n";
                for($i = 0; $i < mysqli_num_fields ( $result ); $i ++) {
                    echo '<td>' . "$row[$i]" . '</td>';
                }
                echo "</tr>\n";
            }
            $result->close();
            mysqli_close();
        ?>
		
        </tbody>
    </table>
    </div>			
		
</body>
</html>
