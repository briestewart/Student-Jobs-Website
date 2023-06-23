<?php
include('Database.php');

// New instance of database class
$db = new Database("bns015", "aim8aiJ9");

// User submits form
if (isset($_POST['submit'])) {
	$field = $_POST['field'];
	$value = $_POST['value'];

	// Check which field was chosen and create corresponding query
	if ($field == "All") {
		$query = "SELECT s.StudentName, j.CompanyName, j.Salary, s.Major FROM Students s 
					JOIN Applications a ON s.StudentID = a.StudentID JOIN Jobs j ON a.JobID = j.JobID";
		$records = $db->selectRecords($query, ["StudentName", "CompanyName", "Salary", "Major"]);
	} elseif ($field == "Major") {
		$query = "SELECT s.Major, s.StudentName, j.CompanyName, j.Salary FROM Students s 
					JOIN Applications a ON s.StudentID = a.StudentID JOIN Jobs j ON a.JobID = j.JobID WHERE s.Major = '$value'";
		$records = $db->selectRecords($query, ["Major","StudentName", "CompanyName", "Salary"]);
	} elseif ($field == "Student") {
		$query = "SELECT s.StudentID, s.StudentName, j.CompanyName, j.Salary, s.Major FROM Students s 
					JOIN Applications a ON s.StudentID = a.StudentID JOIN Jobs j ON a.JobID = j.JobID WHERE s.StudentID = $value";
		$records = $db->selectRecords($query, ["StudentID","StudentName", "CompanyName", "Salary", "Major"]);
	} elseif ($field == "Job") {
		$query = "SELECT j.JobID, s.StudentName, j.CompanyName, j.Salary, s.Major FROM Students s 
					JOIN Applications a ON s.StudentID = a.StudentID JOIN Jobs j ON a.JobID = j.JobID WHERE j.JobID = $value";
		$records = $db->selectRecords($query, ["JobID","StudentName", "CompanyName", "Salary", "Major"]);
	} else {
		echo "ERROR: Invalid option";
	}	
//Display entire table until user submits form
} else {
		$query = "SELECT s.StudentName, j.CompanyName, j.Salary, s.Major FROM Students s 
					JOIN Applications a ON s.StudentID = a.StudentID JOIN Jobs j ON a.JobID = j.JobID";
		$records = $db->selectRecords($query, ["StudentName", "CompanyName", "Salary", "Major"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<button onclick="window.location.href = 'index.html';">Home</button> <br>
	<title>Applications</title>
	<style>
		table {
			width: 70%;
			border-collapse: collapse;
		}
		th, td {
			text-align: left;
			padding: 8px;
		}
		th {
			text-align: left;
			background-color: #7FB886;
			color: white;
		}
		tr:nth-child(odd) {
			background-color: #E9F5EB;
		}
	</style>
</head>
<body>
	<h1>Applications</h1>
	<form action="displayApplication.php" method="post">
		<label for="field">Search by field:</label>
		<select name="field" id="field">
			<option value="All">All Records</option>
			<option value="Major">Major</option>
			<option value="Student">Student ID</option>
			<option value="Job">Job ID</option>
		</select>
        <input type="text" name="value" placeholder="Enter search value">
        <button name="submit" type="submit">Search</button>
	</form>
	<?php // Display table or message
		if ($records) {
			echo "<h3>Records:</h3>";
			echo "<table>";
			echo $records;
			echo "</table>";
		} else {
			echo "No records were found.";
		}
    ?>
</body>
</html>