<?php
$db = new mysqli('localhost', 'root', '', 'FoodService');
mysqli_query($db,"SET NAMES 'utf8'");
mysqli_query($db,"SET CHARACTER SET 'utf8'");
$filename = "C:\wamp64\www\FoodApp\php\salaries.txt";
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
	$sql1 = "SELECT * FROM store WHERE Store_Manager = '".$row['Username']."'";
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
  $totalklm /= 1000;
	$sql2 = "SELECT * FROM timetable_del WHERE username = '".$row["Username"]."' ";
	$result2 = $db->query($sql2);

	$totalhours = 0;
	$totalminutes = 0;
	$totalseconds = 0;
	$startshifts = 0;
	$endshifts = 0;
	$startshiftm = 0;
	$endshiftm = 0;
	$startshifth = 0;
	$endshifth = 0;

	while($row2 = mysqli_fetch_array($result2)){ //��� ���� ������ ��� ������������� ��������

		$salary_month = date("m", strtotime($row2["start_shift"]));
		$salary_year = date("Y", strtotime($row2["start_shift"]));

		if ( ($salary_month == $month) && ($salary_year == $year) ){ //������� ��� ����� ��� ��� ����

			$startshifts   += date("s", strtotime($row2["start_shift"]));
      $endshifts     += date("s", strtotime($row2["end_shift"]));

      $startshiftm   += date("i", strtotime($row2["start_shift"]));
      $endshiftm     += date("i", strtotime($row2["end_shift"]));

      $startshifth   += date("G", strtotime($row2["start_shift"]));
      $endshifth     += date("G", strtotime($row2["end_shift"]));

      $totalminutes = $endshiftm - $startshiftm;
      $totalhours   = $endshifth - $startshifth;
			if($totalminutes>=20){
		    $totalhours++;
		  }
		}
	}

	if ( $year_now >= $year ){
		if ($month_now >= $month ){
			$salarydel = ceil(($totalklm * 0.10) + ( 5 * $totalhours));
		}
	}

	//------------salary---------//
	$data .= "              <amount>".$salarydel."</amount>\n";
	$data .= "          </employee>\n";

}

//---------deliverymen------------//

$data .= "      </employees>\n";
$data .= "  </body>\n";
$data .=  "</xml>\n";
file_put_contents($filename,$data);
?>
