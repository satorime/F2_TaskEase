<?php
ob_start();
include 'connect.php';

if (isset($_POST['btnCreate'])) {
    $taskname        = $_POST['taskname'];
    $taskdescription = $_POST['taskdescription'];
    $duedate         = $_POST['duedate'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbltask WHERE taskname = :taskname");
    $stmt->execute([':taskname' => $taskname]);
    $exists = $stmt->fetchColumn();

    if ($exists > 0) {
        echo "<script>alert('Task name already exists.');</script>";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO tbltask (taskname, taskdescription, taskdate) VALUES (:taskname, :taskdescription, :taskdate)"
        );
        $stmt->execute([
            ':taskname'        => $taskname,
            ':taskdescription' => $taskdescription,
            ':taskdate'        => $duedate,
        ]);
    }
}

if (isset($_POST['btnDelete'])) {
    $taskid = $_POST['taskID'];
    $stmt   = $pdo->prepare("DELETE FROM tbltask WHERE taskid = :taskid");
    $stmt->execute([':taskid' => $taskid]);
}

/* ── Statistics ── */
$total_user_accounts = $pdo->query("SELECT COUNT(*) FROM tbluseraccount")->fetchColumn();
$average_userlength  = $pdo->query("SELECT AVG(LENGTH(username)) FROM tbluseraccount")->fetchColumn();

$total_task      = $pdo->query("SELECT COUNT(*) FROM tbltask")->fetchColumn();
$average_desclength = $pdo->query("SELECT AVG(LENGTH(taskdescription)) FROM tbltask")->fetchColumn();

$row = $pdo->query(
    "SELECT COUNT(*) as total_tasks FROM (
       SELECT taskname FROM tbltaskdeleted
       UNION ALL
       SELECT taskname FROM tbltask
     ) AS tasks"
)->fetch();
$total_tasks = $row['total_tasks'];

$ongoing_tasks = $pdo->query("SELECT COUNT(*) FROM tbltask")->fetchColumn();
$deleted_tasks = $pdo->query("SELECT COUNT(*) FROM tbltaskdeleted")->fetchColumn();

$avg_ongoing_desclength = $pdo->query("SELECT AVG(LENGTH(taskdescription)) FROM tbltask")->fetchColumn();
$avg_deleted_desclength = $pdo->query("SELECT AVG(LENGTH(taskdescription)) FROM tbltaskdeleted")->fetchColumn();
$sum_of_averages        = ($avg_ongoing_desclength + $avg_deleted_desclength) / 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TaskEase — Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/hand-drawn.css">
  <script src="js/redirect-pages.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>

  <nav class="navbar">
    <div class="navbar-brand" onclick="redirectToIndex()">
      <img src="images/taskeaseLogo2.png" alt="TaskEase">
      <span class="navbar-brand-name">TaskEase</span>
    </div>
    <div class="navbar-links">
      <span class="nav-link" onclick="redirectToIndex()">Home</span>
      <span class="nav-link" onclick="redirectToAboutus()">About</span>
      <span class="nav-link" onclick="redirectToContactus()">Contact</span>
      <span class="nav-link" onclick="redirectToDashboard()">Dashboard</span>
      <span class="nav-link primary" onclick="redirectToProfile()">Reports</span>
    </div>
  </nav>

  <div class="page-hero">
    <div class="page-hero-tag">📊 Analytics</div>
    <h1 class="page-hero-title">Reports</h1>
    <p class="page-hero-sub">A snapshot of your TaskEase database.</p>
  </div>

  <div class="profile-wrap">

    <!-- Stats pills -->
    <div class="stats-row">
      <div class="stat-pill">
        <div class="stat-val"><?php echo $total_user_accounts; ?></div>
        <div class="stat-lbl">Total Users</div>
      </div>
      <div class="stat-pill" style="background:var(--yellow);">
        <div class="stat-val"><?php echo $ongoing_tasks; ?></div>
        <div class="stat-lbl">Ongoing Tasks</div>
      </div>
      <div class="stat-pill" style="background:#fff0f0;">
        <div class="stat-val"><?php echo $deleted_tasks; ?></div>
        <div class="stat-lbl">Deleted Tasks</div>
      </div>
      <div class="stat-pill">
        <div class="stat-val"><?php echo $total_tasks; ?></div>
        <div class="stat-lbl">Total Tasks</div>
      </div>
    </div>

    <!-- User accounts table -->
    <div class="profile-block">
      <div class="block-title">👤 User Account List</div>
      <table class="hand-table">
        <thead>
          <tr>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $stmt = $pdo->query(
              "SELECT a.acctid, p.userid, a.emailadd, p.firstname, p.lastname, a.username
               FROM tbluseraccount a
               JOIN tbluserprofile p ON a.acctid = p.acctid"
            );
            while ($row = $stmt->fetch()):
          ?>
          <tr>
            <td><?php echo htmlspecialchars($row['emailadd']); ?></td>
            <td><?php echo htmlspecialchars($row['firstname']); ?></td>
            <td><?php echo htmlspecialchars($row['lastname']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
          </tr>
          <?php endwhile; ?>
          <tr class="footer-row">
            <td colspan="2">Total Users: <strong><?php echo $total_user_accounts; ?></strong></td>
            <td colspan="2">Avg. Username Length: <strong><?php echo round($average_userlength, 2); ?></strong></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- All tasks (ongoing + deleted) -->
    <div class="profile-block">
      <div class="block-title">📋 All Tasks (Ongoing + Deleted)</div>
      <table class="hand-table">
        <thead>
          <tr>
            <th>Status</th>
            <th>Task Name</th>
            <th>Description</th>
            <th>Due Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $stmt = $pdo->query(
              "SELECT 'Deleted' AS status, taskname, taskdescription, taskdate FROM tbltaskdeleted
               UNION ALL
               SELECT 'Ongoing' AS status, taskname, taskdescription, taskdate FROM tbltask
               ORDER BY taskdate"
            );
            while ($row = $stmt->fetch()):
              $statusStyle = $row['status'] === 'Deleted'
                ? 'color:var(--accent); font-weight:700;'
                : 'color:var(--blue); font-weight:700;';
          ?>
          <tr>
            <td style="<?php echo $statusStyle; ?>"><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['taskname']); ?></td>
            <td><?php echo htmlspecialchars($row['taskdescription']); ?></td>
            <td><?php echo htmlspecialchars($row['taskdate']); ?></td>
          </tr>
          <?php endwhile; ?>
          <tr class="footer-row">
            <td>Ongoing: <strong><?php echo $ongoing_tasks; ?></strong></td>
            <td>Deleted: <strong><?php echo $deleted_tasks; ?></strong></td>
            <td>Total: <strong><?php echo $total_tasks; ?></strong></td>
            <td>Avg. Desc Len: <strong><?php echo round($sum_of_averages, 2); ?></strong></td>
          </tr>
        </tbody>
      </table>

      <!-- Chart -->
      <div class="chart-container">
        <canvas id="taskChart"></canvas>
      </div>
    </div>

    <!-- Ongoing tasks only -->
    <div class="profile-block">
      <div class="block-title">✅ Ongoing Task List</div>
      <table class="hand-table">
        <thead>
          <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Due Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $stmt = $pdo->query("SELECT taskid, taskname, taskdescription, taskdate FROM tbltask");
            while ($row = $stmt->fetch()):
          ?>
          <tr>
            <td><?php echo htmlspecialchars($row['taskname']); ?></td>
            <td><?php echo htmlspecialchars($row['taskdescription']); ?></td>
            <td><?php echo htmlspecialchars($row['taskdate']); ?></td>
          </tr>
          <?php endwhile; ?>
          <tr class="footer-row">
            <td>Total: <strong><?php echo $total_task; ?></strong></td>
            <td colspan="2">Avg. Desc Length: <strong><?php echo round($average_desclength, 2); ?></strong></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div><!-- /profile-wrap -->

  <script>
    var ctx = document.getElementById('taskChart').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Ongoing', 'Deleted'],
        datasets: [{
          data: [<?php echo $ongoing_tasks; ?>, <?php echo $deleted_tasks; ?>],
          backgroundColor: ['#2d5da1', '#ff4d4d'],
          borderColor:     ['#2d2d2d', '#2d2d2d'],
          borderWidth: 2
        }]
      },
      options: {
        legend: { labels: { fontFamily: 'Patrick Hand', fontSize: 14 } }
      }
    });
  </script>

</body>
</html>
