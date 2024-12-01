<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Reports</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <?= view('style') ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .content {
            margin: 2em auto;
            max-width: 1200px;
        }

        .summary-boxes {
            display: flex;
            gap: 2em;
            margin-bottom: 2em;
            justify-content: space-between;
        }

        .summary-box {
            flex: 1;
            background: white;
            padding: 1.5em;
            border-radius: 0.5em;
            box-shadow: 0 0.5em 1em rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .summary-box h2 {
            font-size: 1.5em;
            margin-bottom: 0.5em;
        }

        .summary-box p {
            font-size: 2em;
            font-weight: bold;
            margin: 0;
        }

        .section {
            margin-bottom: 3em;
        }

        .charts {
            display: flex;
            flex-wrap: wrap;
            gap: 2em;
            justify-content: center;
        }

        .chart-container {
            flex: 1 1 30%;
            background: white;
            padding: 1.5em;
            border-radius: 0.5em;
            min-width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 0.5em;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
<?= view('adminheader') ?>
<div class="content">
    <h1>Reports</h1>

    <!-- Summary Boxes Section -->
    <div class="summary-boxes">
        <div class="summary-box">
            <h2>Total Users</h2>
            <p><?= $totalUsers ?></p>
        </div>
        <div class="summary-box">
            <h2>Total Items</h2>
            <p><?= $totalItems ?></p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="section">
        <h2>Charts</h2>
        <div class="charts">
            <div class="chart-container">
                <h3>Stock Items by Category</h3>
                <canvas id="stockChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Defective Items by Category</h3>
                <canvas id="defectiveChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Unusable Equipment Section -->
    <div class="section">
        <h2>Unusable Equipment</h2>
        <table>
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($unusableEquipment as $equipment): ?>
                <tr>
                    <td><?= $equipment['item_id'] ?></td>
                    <td><?= $equipment['name'] ?></td>
                    <td><?= $equipment['category'] ?></td>
                    <td><?= $equipment['status'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Borrowing History Section -->
    <div class="section">
        <h2>User Borrowing History</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Item ID</th>
                    <th>Date Borrowed</th>
                    <th>Date Returned</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowingHistory as $history): ?>
                <tr>
                    <td><?= $history['email'] ?></td>
                    <td><?= $history['item_id'] ?></td>
                    <td><?= $history['borrow_date'] ?></td>
                    <td><?= $history['return_date'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const renderChart = (id, data, label) => {
        const ctx = document.getElementById(id).getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: label }
                }
            }
        });
    };

    renderChart('stockChart', {
        labels: <?= json_encode(array_column($stockData, 'category')) ?>,
        values: <?= json_encode(array_column($stockData, 'total')) ?>
    }, 'Stock Items by Category');

    renderChart('defectiveChart', {
        labels: <?= json_encode(array_column($defectiveData, 'category')) ?>,
        values: <?= json_encode(array_column($defectiveData, 'total')) ?>
    }, 'Defective Items by Category');
</script>
</body>
</html>
