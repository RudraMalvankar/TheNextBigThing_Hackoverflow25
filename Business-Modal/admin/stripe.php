<?php
session_start();
require 'db_config.php';

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Set Stripe API Key
\Stripe\Stripe::setApiKey(STRIPE_SECRET);

try {
    // ✅ Fetch all customers from Stripe
    $customers = \Stripe\Customer::all(['limit' => 100]);
    
    // ✅ Fetch all subscriptions
    $subscriptions = \Stripe\Subscription::all(['limit' => 100]);

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Stripe Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body { background-color: #1e1e2d; color: #ffffff; }
        .container { margin-top: 30px; }
        .card { background: #29293d; color: #fff; }
        .table-dark th { background: #343a40; }
        .export-btn { background: #007bff; border: none; padding: 8px 12px; color: white; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Stripe Dashboard</h2>

    <!-- ✅ Customers Table -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Customers</h4>
            <button class="export-btn" onclick="exportToCSV('customers', 'customers.csv')"><i class="fas fa-download"></i> Export</button>
        </div>
        <div class="card-body">
            <table class="table table-striped table-dark" id="customers-table">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Email</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers->data as $customer): ?>
                        <tr>
                            <td><?= htmlspecialchars($customer->id) ?></td>
                            <td><?= htmlspecialchars($customer->email) ?></td>
                            <td><?= htmlspecialchars($customer->name ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ✅ Subscriptions Table -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Subscriptions</h4>
            <button class="export-btn" onclick="exportToCSV('subscriptions', 'subscriptions.csv')"><i class="fas fa-download"></i> Export</button>
        </div>
        <div class="card-body">
            <table class="table table-striped table-dark" id="subscriptions-table">
                <thead>
                    <tr>
                        <th>Subscription ID</th>
                        <th>Customer ID</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Next Billing Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscriptions->data as $sub): ?>
                        <tr>
                            <td><?= htmlspecialchars($sub->id) ?></td>
                            <td><?= htmlspecialchars($sub->customer) ?></td>
                            <td><?= htmlspecialchars($sub->status) ?></td>
                            <td><?= date("Y-m-d", $sub->start_date) ?></td>
                            <td><?= date("Y-m-d", $sub->current_period_end) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ✅ Chart Section -->
    <div class="card shadow mt-4">
        <div class="card-header"><h4>Subscription Overview</h4></div>
        <div class="card-body">
            <canvas id="subscriptionsChart"></canvas>
        </div>
    </div>
</div>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ✅ Chart.js Data Visualization
const ctx = document.getElementById('subscriptionsChart').getContext('2d');
const subscriptionsData = {
    labels: ['Active', 'Canceled', 'Incomplete'],
    datasets: [{
        label: 'Subscriptions',
        data: [
            <?= count(array_filter($subscriptions->data, fn($sub) => $sub->status === 'active')) ?>,
            <?= count(array_filter($subscriptions->data, fn($sub) => $sub->status === 'canceled')) ?>,
            <?= count(array_filter($subscriptions->data, fn($sub) => $sub->status === 'incomplete')) ?>
        ],
        backgroundColor: ['#28a745', '#dc3545', '#ffc107']
    }]
};
new Chart(ctx, { type: 'pie', data: subscriptionsData });

// ✅ Export to CSV
function exportToCSV(tableId, filename) {
    let csv = [];
    let rows = document.querySelectorAll(`#${tableId}-table tr`);
    for (let row of rows) {
        let cols = row.querySelectorAll("td, th");
        let rowData = [];
        cols.forEach(col => rowData.push(col.innerText));
        csv.push(rowData.join(","));
    }
    let csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
    let encodedUri = encodeURI(csvContent);
    let link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", filename);
    document.body.appendChild(link);
    link.click();
}
</script>
</body>
</html>
