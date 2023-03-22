<!DOCTYPE html>
<html>
<head>
	<title>iPhone Inventory System - User Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
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
			<tr>
				<td>iPhone 11</td>
				<td>The iPhone 11 is a smartphone designed, developed, and marketed by Apple Inc.</td>
				<td>Black</td>
				<td class="quantity">10</td>
				<td>$699.00</td>
				<td><button class="add-to-cart">Add to Cart</button></td>
			</tr>
			<tr>
				<td>iPhone 12</td>
				<td>The iPhone 12 is a smartphone designed, developed, and marketed by Apple Inc.</td>
				<td>White</td>
				<td class="quantity low-stock">2</td>
				<td>$799.00</td>
				<td><button class="add-to-cart">Add to Cart</button></td>
			</tr>
			<tr>
				<td>iPhone 13</td>
				<td>The iPhone 13 is a smartphone designed, developed, and marketed by Apple Inc.</td>
				<td>Red</td>
				<td class="quantity">5</td>
				<td>$999.00</td>
				<td><button class="add-to-cart">Add to Cart</button></td>
			</tr>
		</tbody>
	</table>
	<script>
		// Check if user is logged in, if not redirect to login page
		if (localStorage.getItem("isLoggedIn") !== "true") {
			window.location.href = "login.php";
		}
	</script>
</body>
</html>

