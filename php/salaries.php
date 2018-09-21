<?php
$db = new mysqli('localhost', 'root', '', 'FoodService');
mysqli_query($db,"SET NAMES 'utf8'");
mysqli_query($db,"SET CHARACTER SET 'utf8'");

$month = $_GET['month'];
$year = $_GET['year'];

$data =  "<xml>\n";
$data .= "  <header>\n";
$data .= "      <transaction>\n";
$month_now = date("m");
$year_now = date("Y");
$data .= "          <period month='".$month."' year='".$year."'/>\n";
$data .= "      </transaction>\n";
$data .= "  </header>\n";
$data .= "  <body>\n";
$data .= "      <employees>\n";

//---------managers------------//
$sql = "SELECT * FROM manager ";
$result = $db->query($sql);
while($row = mysqli_fetch_array($result)){  //��� ���� ������ ��� ������ => ��� ���� ��������

	$data .= "          <employee>\n";
	$data .= "              <firstname>".$row["Name"]."</firstname>\n";
	$data .= "              <lastname>".$row["Surname"]."</lastname>\n";
	$data .= "              <amka>".$row["AMKA"]."</amka>\n";
	$data .= "              <afm>".$row["AFM"]."</afm>\n";
	$data .= "              <iban>".$row["IBAN"]."</iban>\n";

	//------------salary---------//
	$sql1 = "SELECT * FROM stores WHERE Store_Manager = '".$row['Username']."'";
	$result1 = mysqli_query($db,$sql1);
	$row1 =  mysqli_fetch_array($result1);

	$sql2 = "SELECT * FROM orders WHERE st_address = '".$row1["Store_Name"]."' ";
	$result2 = $db->query($sql2);

	$salaryman = 0;
	$totalincome = 0; //������ �� ������ ��� ������������

	while($row2 = mysqli_fetch_array($result2)){ //�� ���� ��� �����������

		$salary_month = date("m", strtotime($row2["dateoforder"]));
		$salary_year = date("Y", strtotime($row2["dateoforder"]));

		if ( ($salary_month == $month) && ($salary_year == $year) ){ //������� ��� ����� ��� ��� ����
			$totalincome = $totalincome + $row2["cost"];
		}

	}

	if ( $year_now >= $year ){
		if ($month_now >= $month ){
			$salaryman = 800 + ($totalincome * 0.02 ); //2% ��� ��������� ������
		}
	}

	//------------salary---------//

	$salaryman = floor ($salaryman * 100) /100;
	$data .= "              <amount>".$salaryman."</amount>\n";
	$data .= "          </employee>\n";
}


//---------managers------------//


//---------deliverymen------------//
$sql = "SELECT * FROM deliverygirlboy ";
$result = $db->query($sql);

while($row = mysqli_fetch_array($result)){  //��� ���� ������ ��� ������ => ��� ���� ��������

	$data .= "          <employee>\n";
	$data .= "              <firstname>".$row["Name"]."</firstname>\n";
	$data .= "              <lastname>".$row["Surname"]."</lastname>\n";
	$data .= "              <amka>".$row["AMKA"]."</amka>\n";
	$data .= "              <afm>".$row["AFM"]."</afm>\n";
	$data .= "              <iban>".$row["IBAN"]."</iban>\n";

	//------------salary---------//

	$sql1 = "SELECT * FROM orders WHERE deliverygirlboy = '".$row["Username"]."' ";
	$result1 = $db->query($sql1);

	$totalklm = 0;
	$salarydel = 0;

	while($row1 = mysqli_fetch_array($result1)){ //��� ���� ���������� ��� ������������� ��������

		$salary_month = date("m", strtotime($row1["dateoforder"]));
		$salary_year = date("Y", strtotime($row1["dateoforder"]));

		if ( ($salary_month == $month) && ($salary_year == $year) ){ //������� ��� ����� ��� ��� ����
			$totalklm = $totalklm + $row1["kilometers"] + $row1["mydistfromstore"]; //������� �� �����
		}
	}

	$sql2 = "SELECT * FROM timetable_del WHERE username = '".$row["Username"]."' ";
	$result2 = $db->query($sql2);

	$totalhours = 0;
	$totalminutes = 0;
	$totalseconds = 0;
	$totalsecondspershift = 0;

	while($row2 = mysqli_fetch_array($result2)){ //��� ���� ������ ��� ������������� ��������

		$salary_month = date("m", strtotime($row2["start_shift"]));
		$salary_year = date("Y", strtotime($row2["start_shift"]));

		if ( ($salary_month == $month) && ($salary_year == $year) ){ //������� ��� ����� ��� ��� ����

			$time1 = $row2["start_shift"];
			$time2 = $row2["end_shift"];
			$totalsecondspershift = $totalsecondspershift + (strtotime($time2) - strtotime($time1)); //�������� ������������� ���� ��� ������� ����� ��� ����

			$hours = $totalsecondspershift/3600;
			$hours = floor($hours);

			$minutes = ($totalsecondspershift/60) - ($hours * 3600);
			$minutes = floor($minutes);

			$seconds = $totalsecondspershift - ($hours * 3600) - ($minutes * 60);

			$totalhours = $totalhours + $hours;
			$totalminutes = $totalminutes + $minutes;
			$totalseconds = $totalseconds + $seconds;
		}
	}

	if ( $year_now >= $year ){
		if ($month_now >= $month ){
			$salarydel = ($totalklm * 0.0001) + ( 5 * $totalhours) + ( 0.05 * $totalminutes) + ( 0.0008333333 * $totalseconds);
		}
	}

	//------------salary---------//
	$salarydel = floor ($salarydel * 100) /100;
	$data .= "              <amount>".$salarydel."</amount>\n";
	$data .= "          </employee>\n";

}

//---------deliverymen------------//

$data .= "      </employees>\n";
$data .= "  </body>\n";
$data .=  "</xml>\n";
echo $data;
?>
