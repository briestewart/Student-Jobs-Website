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
		$query = "SELECT * FROM Employers";
		$records = $db->selectRecords($query, ["CompanyName", "CompanySize", "State"]);
	} elseif ($field == "State") {
		$query = "SELECT State, CompanyName, CompanySize FROM Employers WHERE State = '$value'";
		$records = $db->selectRecords($query, ["State", "CompanyName", "CompanySize"]);
	} elseif ($field == "Name") {
		$query = "SELECT Jobs.JobID, Jobs.JobTitle, Employers.CompanyName, Employers.CompanySize, Employers.State, 
					COUNT(Applications.StudentID) AS Applicants FROM Jobs JOIN Employers ON Jobs.CompanyName = Employers.CompanyName 
					LEFT JOIN Applications ON Jobs.JobID = Applications.JobID WHERE Employers.CompanyName = '$value' 
					GROUP BY Jobs.JobID, Jobs.JobTitle, Employers.CompanyName, Employers.CompanySize, Employers.State";
		$records = $db->selectRecords($query, ["JobID", "JobTitle", "CompanyName","CompanySize", "State", "Applicants"]);
	} else {
		echo "ERROR: Invalid option";
	}
//Display entire table until user submits form
} else {
		$query = "SELECT * FROM Employers";
		$records = $db->selectRecords($query, ["CompanyName", "CompanySize", "State"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<button onclick="window.location.href = 'index.html';">Home</button> <br>
	<title>Employers</title>
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
	<h1>Employers</h1>
	<form action="displayEmployer.php" method="post">
		<label for="field">Search by field:</label>
		<select name="field" id="field">
			<option value="All">All Records</option>
			<option value="State">State</option>
			<option value="Name">Name</option><l  
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