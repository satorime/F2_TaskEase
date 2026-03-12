<?php
    include 'connect.php';

    if (isset($_POST['btnCreate'])) {
        $taskname        = $_POST['taskname'];
        $taskdescription = $_POST['taskdescription'];
        $duedate         = $_POST['duedate'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbltask WHERE taskname = :taskname");
        $stmt->execute([':taskname' => $taskname]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            echo "<script>alert('Task name already exists. Please choose a different name.');</script>";
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
        $stmt = $pdo->prepare("DELETE FROM tbltask WHERE taskid = :taskid");
        $stmt->execute([':taskid' => $taskid]);
    }

    // ---- Statistics queries ----

    $stmt = $pdo->query("SELECT COUNT(*) FROM tbluseraccount");
    $total_user_accounts = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT AVG(LENGTH(username)) as average_userlength FROM tbluseraccount");
    $row = $stmt->fetch();
    $average_userlength = $row['average_userlength'];

    $stmt = $pdo->query("SELECT COUNT(*) FROM tbltask");
    $total_task = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT AVG(LENGTH(taskdescription)) as average_desclength FROM tbltask");
    $row = $stmt->fetch();
    $average_desclength = $row['average_desclength'];

    // Total tasks across both tables (no ORDER BY inside subquery for PostgreSQL compatibility)
    $stmt = $pdo->query(
        "SELECT COUNT(*) as total_tasks FROM (
            SELECT taskname FROM tbltaskdeleted
            UNION ALL
            SELECT taskname FROM tbltask
        ) AS tasks"
    );
    $row = $stmt->fetch();
    $total_tasks = $row['total_tasks'];

    $stmt = $pdo->query("SELECT COUNT(*) as ongoing_tasks FROM tbltask");
    $row = $stmt->fetch();
    $ongoing_tasks = $row['ongoing_tasks'];

    $stmt = $pdo->query("SELECT COUNT(*) as deleted_tasks FROM tbltaskdeleted");
    $row = $stmt->fetch();
    $deleted_tasks = $row['deleted_tasks'];

    $stmt = $pdo->query("SELECT AVG(LENGTH(taskdescription)) as avg_ongoing_desclength FROM tbltask");
    $row = $stmt->fetch();
    $avg_ongoing_desclength = $row['avg_ongoing_desclength'];

    $stmt = $pdo->query("SELECT AVG(LENGTH(taskdescription)) as avg_deleted_desclength FROM tbltaskdeleted");
    $row = $stmt->fetch();
    $avg_deleted_desclength = $row['avg_deleted_desclength'];

    $sum_of_averages = ($avg_ongoing_desclength + $avg_deleted_desclength) / 2;
?>

<html>
    <head>
        <title> TaskEase - Report List </title>
        <link rel="stylesheet" href="css/profile.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&display=swap">
        <script src="js/redirect-pages.js"></script>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    </head>

    <body>
        <div class="page-header">
            <div class="header-logo">
                <img src = "images/taskeaseLogo2.png" />
            </div>

            <div class="header-logo-name">
                <div class="name-upper-text">
                    <span> TaskEase </span>
                </div>

                <div class="name-lower-text">
                    <span> task management</span>
                </div>
            </div>

            <div class="header-anchors" onclick="redirectToIndex();">
                <span> HOME </span>
            </div>

            <div class="header-anchors" onclick="redirectToAboutus();">
                <span> ABOUT US </span>
            </div>

            <div class="header-anchors" onclick="redirectToContactus();">
                <span> CONTACT US </span>
            </div>

            <div class="header-anchors" onclick="redirectToDashboard()"><span> DASHBOARD </span>
            </div>

            <div class="header-anchors" onclick="redirectToProfile()">
                <span> REPORT PAGE </span>
            </div>
        </div>

		<h1 style="font-size: 60px;"> TASKEASE DATABASE LIST </h1>

            <div class="addtaskright">
				<div class="alltask-container">
                    <div class="headername">
                        <span> USER - ACCOUNT LIST </span>
                    </div>

                    <div class = "aboutus-body">
                        <div class="content-text">
                            <table class="createTable">
                                <tr>
                                    <td class="tableheader"> Email Address </td>
                                    <td class="tableheader"> First Name </td>
                                    <td class="tableheader"> Last Name </td>
                                    <td class="tableheader"> Username </td>
                                </tr>
                                <?php
                                    $stmt = $pdo->query(
                                        "SELECT a.acctid, p.userid, a.emailadd, p.firstname, p.lastname, a.username
                                         FROM tbluseraccount a
                                         JOIN tbluserprofile p ON a.acctid = p.acctid"
                                    );
                                    while ($row = $stmt->fetch()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['emailadd'])   . "</td>";
                                        echo "<td>" . htmlspecialchars($row['firstname'])  . "</td>";
                                        echo "<td>" . htmlspecialchars($row['lastname'])   . "</td>";
                                        echo "<td>" . htmlspecialchars($row['username'])   . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td colspan='4'>Total number of Users: $total_user_accounts</td></tr>";
                                    echo "<tr><td colspan='4'>Average length of Usernames: " . round($average_userlength, 3) . " </td></tr>";
                                ?>
                            </table>
                        </div>
                    </div>

					<br/>

                </div>

                <div class="alltask-container">
                    <div class="headername">
                        <span> SECTION - TASK LIST </span>
                    </div>

                    <div class = "aboutus-body">
                        <div class="content-text">
                            <table class="createTable">
                                <tr>
                                    <td class="tableheader"> Status </td>
                                    <td class="tableheader"> Task Name </td>
                                    <td class="tableheader"> Task Description </td>
                                    <td class="tableheader"> Due Date </td>
                                </tr>
                                <?php
                                    $stmt = $pdo->query(
                                        "SELECT 'Deleted' AS status, taskname, taskdescription, taskdate FROM tbltaskdeleted
                                         UNION ALL
                                         SELECT 'Ongoing' AS status, taskname, taskdescription, taskdate FROM tbltask
                                         ORDER BY taskdate"
                                    );
                                    while ($row = $stmt->fetch()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['status'])          . "</td>";
                                        echo "<td>" . htmlspecialchars($row['taskname'])        . "</td>";
                                        echo "<td>" . htmlspecialchars($row['taskdescription']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['taskdate'])        . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td colspan='4'>Number of Ongoing Tasks: $ongoing_tasks</td></tr>";
                                    echo "<tr><td colspan='4'>Number of Deleted Tasks: $deleted_tasks</td></tr>";
                                    echo "<tr><td colspan='4'>Total number of Tasks: $total_tasks</td></tr>";
                                    echo "<tr><td colspan='4'>Average length of task description of Deleted and Ongoing Tasks: " . round($sum_of_averages, 3) . "</td></tr>";
                            ?>
                            </table>
                        </div>
                    </div>

                    <canvas id="taskChart" width="200" height="200"></canvas>
                    <script>
                        var ctx = document.getElementById('taskChart').getContext('2d');
                        var taskChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ['Ongoing Tasks', 'Deleted Tasks'],
                                datasets: [{
                                    label: '# of Tasks',
                                    data: [<?php echo $ongoing_tasks;?>, <?php echo $deleted_tasks;?>],
                                    backgroundColor: [
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(255, 182, 193, 1)'
                                    ],
                                    borderColor: [
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(255, 182, 193, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>

                <div class="alltask-container">
                    <div class="headername">
                        <span> TASK LIST </span>
                    </div>
                    <div class = "aboutus-body">
                        <div class="content-text">
                            <table class="createTable">
                                <tr>
                                    <td class="tableheader"> Task Name </td>
                                    <td class="tableheader"> Task Description </td>
                                    <td class="tableheader"> Due Date </td>
                                </tr>
                                <?php
                                    $stmt = $pdo->query("SELECT taskid, taskname, taskdescription, taskdate FROM tbltask");
                                    while ($row = $stmt->fetch()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['taskname'])        . "</td>";
                                        echo "<td>" . htmlspecialchars($row['taskdescription']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['taskdate'])        . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td colspan='4'>Total number of Tasks: $total_task</td></tr>";
                                    echo "<tr><td colspan='4'>Average length of Task Description: " . round($average_desclength, 3) . " </td></tr>";
                                ?>
                            </table>
                        </div>
                    </div>

					<br/>

                </div>
            </div>
        </body>
    </html>
