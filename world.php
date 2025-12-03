<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';

if (!empty($country)) {
    $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
} else {
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>World Database Results</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .no-results {
            padding: 20px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <?php if (count($results) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Continent</th>
                    <th>Independence</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['continent']) ?></td>
                        <td><?= !empty($row['independence_year']) ? htmlspecialchars($row['independence_year']) : 'N/A' ?></td>
                        <td><?= htmlspecialchars($row['head_of_state']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-results">
            No countries found matching your search.
        </div>
    <?php endif; ?>
</body>
</html>