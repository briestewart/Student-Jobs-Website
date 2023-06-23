<?php
include('Database.php');

// New instance of database class
$db = new Database("bns015", "aim8aiJ9");

// Get all majors in table
$majors = array();
$results = $db->selectValues('Jobs', 'DesiredMajor');
foreach ($results as $row) {
	$temp = implode(",", $row);
	$majors[] = $temp;
}

// User submits form
if (isset($_POST['submit'])) {
    $field = $_POST["field"];
    $value = $_POST["value"];
	
	// Check which field was chosen and create query
    if ($field == "All") {
		$query = "SELECT * FROM Jobs";
        $records = $db->selectRecords($query, ['JobID', 'CompanyName', 'JobTitle', 'Salary', 'DesiredMajor']);
    } else {
        $query = "SELECT * FROM Jobs WHERE DesiredMajor = '$value'";
        $records = $db->selectRecords($query, ['JobID', 'CompanyName', 'JobTitle', 'Salary', 'DesiredMajor']);
    }
//Display entire table until user submits form
} else {
		$query = "SELECT * FROM Jobs";
        $records = $db->selectRecords($query, ['JobID', 'CompanyName', 'JobTitle', 'Salary', 'DesiredMajor']);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<button onclick="window.location.href = 'index.html';">Home</button> <br>
    <title>Jobs</title>
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
    <h1>Jobs</h1>
	<form action="displayJob.php" method="post">
		<label>Search:</label>
		<input type="radio" id="All" name="field" value="All">
		<label for="All">All</label>
		<input type="radio" id="Major" name="field" value="Major">
		<label for="Major">By Major</label>
		<!--Display available majors in a drop-down list-->
        <?php if ($majors): ?>
            <select name="value">
				<?php foreach ($majors as $major): ?>
					<option><?= $major ?></option>
				<?php endforeach; ?>
            </select>
        <?php endif; ?> 
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