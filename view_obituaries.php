<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obituary_platform";

// Establish a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination setup
$results_per_page = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $results_per_page;

// Write a SQL query to select all records from the obituaries table
$sql = "SELECT * FROM obituaries ORDER BY submission_date DESC LIMIT $start_from, $results_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Obituaries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #007bff;
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Obituaries</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Date of Death</th>
                <th>Content</th>
                <th>Author</th>
                <th>Submission Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["name"]."</td>
                            <td>".$row["date_of_birth"]."</td>
                            <td>".$row["date_of_death"]."</td>
                            <td>".$row["content"]."</td>
                            <td>".$row["author"]."</td>
                            <td>".$row["submission_date"]."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No obituaries found</td></tr>";
            }
            ?>
        </table>

        <div class="pagination">
            <?php
            $sql = "SELECT COUNT(id) AS total FROM obituaries";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_pages = ceil($row["total"] / $results_per_page);

            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='view_obituaries.php?page=".$i."'";
                if ($i == $page) {
                    echo " style='background-color: #007bff; color: white;'";
                }
                echo ">".$i."</a> ";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
