<?php
require_once('db_config.php');
\Stripe\Stripe::setApiKey(STRIPE_SECRET);

// Fetch total users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = ($result_users->num_rows > 0) ? $result_users->fetch_assoc()['total_users'] : 0;

// Fetch new signups today
$sql_new_signups = "SELECT COUNT(*) AS new_signups FROM users WHERE DATE(created_at) = CURDATE()";
$result_signups = $conn->query($sql_new_signups);
$new_signups = ($result_signups->num_rows > 0) ? $result_signups->fetch_assoc()['new_signups'] : 0;

// Fetch total revenue
$total_revenue = 0;
$revenue_data = \Stripe\BalanceTransaction::all(['limit' => 100]);
foreach ($revenue_data->autoPagingIterator() as $txn) {
    $total_revenue += $txn->amount / 100;
}

// Fetch active subscriptions & trial users
$active_users = 0;
$trial_users = 0;
$subscriptions = \Stripe\Subscription::all(['limit' => 100]);

foreach ($subscriptions->data as $sub) {
    if ($sub->status === 'active') {
        $active_users++;
    }
    if ($sub->trial_end && $sub->trial_end > time()) {
        $trial_users++;
    }
}

// Fetch revenue and unique paying users per day
$daily_revenue = [];
$daily_users = [];
$charges = \Stripe\Charge::all(['limit' => 100]);
foreach ($charges->data as $charge) {
    $date = date('Y-m-d', $charge->created);
    $user_id = $charge->customer;

    if (!isset($daily_revenue[$date])) {
        $daily_revenue[$date] = 0;
        $daily_users[$date] = [];
    }

    $daily_revenue[$date] += $charge->amount / 100;
    $daily_users[$date][$user_id] = true;
}
$revenue_dates = array_keys($daily_revenue);
$revenue_values = array_values($daily_revenue);
$user_counts = array_map('count', $daily_users);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f4f4f4; color: #333; padding: 20px; }
        .dashboard-container { max-width: 1200px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        .stats-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { flex: 1; min-width: 200px; padding: 20px; background: linear-gradient(135deg, #6e8efb, #a777e3); color: white; text-align: center; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        .stat-box h2 { font-size: 28px; margin-bottom: 5px; }
        .stat-box p { font-size: 16px; opacity: 0.9; }
        .chart-container { display: flex; flex-direction: column; gap: 20px; align-items: center; }
        canvas { background: white; padding: 15px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); width: 80%; }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1 style="text-align: center; margin-bottom: 20px;">📊 Admin Dashboard</h1>
    <div class="stats-container">
        <div class="stat-box"><h2><?php echo $total_users; ?></h2><p>Total Users</p></div>
        <div class="stat-box"><h2>₹<?php echo number_format($total_revenue, 2); ?></h2><p>Total Revenue</p></div>
        <div class="stat-box"><h2><?php echo $new_signups; ?></h2><p>New Signups Today</p></div>
        <div class="stat-box"><h2><?php echo $active_users; ?></h2><p>Active Paid Users</p></div>
        <div class="stat-box"><h2><?php echo $trial_users; ?></h2><p>Users on Trial</p></div>
    </div>
    <div class="chart-container">
        <canvas id="userChart"></canvas>
        <canvas id="revenueChart"></canvas>
    </div>
</div>
<script>
    var ctx1 = document.getElementById('userChart').getContext('2d');
    var userChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($revenue_dates); ?>,
            datasets: [{
                label: 'Users Who Bought',
                data: <?php echo json_encode($user_counts); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    var ctx2 = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($revenue_dates); ?>,
            datasets: [{
                label: 'Revenue Per Day',
                data: <?php echo json_encode($revenue_values); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
</body>
</html>