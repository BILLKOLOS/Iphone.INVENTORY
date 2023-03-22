<!DOCTYPE html>
<html>
<head>
	<title>iPhone Inventory System - User Page</title>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
		}

		th {
			background-color: #ccc;
			color: #333;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		tr:hover {
			background-color: #ddd;
		}

		td.quantity {
			font-weight: bold;
		}

		td.low-stock {
			color: red;
		}

		button.add-to-cart {
			background-color: #4CAF50;
			border: none;
			color: white;
			padding: 8px 16px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			margin: 4px 2px;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<h1>iPhone Inventory System - User Page</h1>
	<table>
		<thead>
			<tr>
				<th>Model</th>
				<th>Description</th>
				<th>Color</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// Connect to database
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "inventory";
				$conn = mysqli_connect($servername, $username, $password, $dbname);

				if (!$conn) {
				    die("Connection failed: " . mysqli_connect_error());
				}

				// Query inventory table
				$sql = "SELECT * FROM inventory";
				$result = mysqli_query($conn, $sql);

				// Generate table rows from query result
				if (mysqli_num_rows($result) > 0) {
				    while($row = mysqli_fetch_assoc($result)) {
				        echo "<tr>";
				        echo "<td>" . $row["model"] . "</td>";
				        echo "<td>" . $row["description"] . "</td>";
				        echo "<td>" . $row["color"] . "</td>";
				        echo "<td class='quantity";
				        if ($row["quantity"] < 5) {
				        	echo " low-stock";
				        }
				        echo "'>" . $row["quantity"] . "</td>";
				        echo "<td>" . $row["price"] . "</td>";
				        echo "<td><button class='add-to-cart'>Add to Cart</button></td>";
				        echo "</tr>";
				    }
				} else {
				    echo "0 results";
				}

				// Close database connection
				mysqli_close($conn);
			?>
		</tbody>
	</table>
</body>
</html>

