<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

if (!empty($country)) {
    if ($lookup === 'cities') {
        $stmt = $conn->query("
            SELECT cities.name, cities.district, cities.population
            FROM cities 
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE '%$country%'
            ORDER BY cities.population DESC
        ");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $isCityLookup = true;
    } else {
        $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $isCityLookup = false;
    }
} else {
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $isCityLookup = false;
}
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
                    <?php if ($isCityLookup): ?>
                        <th>Name</th>
                        <th>District</th>
                        <th>Population</th>
                    <?php else: ?>
                        <th>Name</th>
                        <th>Continent</th>
                        <th>Independence</th>
                        <th>Head of State</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <?php if ($isCityLookup): ?>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['district']) ?></td>
                            <td><?= number_format($row['population']) ?></td>
                        <?php else: ?>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['continent']) ?></td>
                            <td><?= !empty($row['independence_year']) ? htmlspecialchars($row['independence_year']) : 'N/A' ?></td>
                            <td><?= htmlspecialchars($row['head_of_state']) ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-results">
            No results found matching your search.
        </div>
    <?php endif; ?>
</body>
</html>