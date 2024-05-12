<?php
    include 'connect.php';

    if (isset($_POST['btnCreate'])) {
        $taskname = mysqli_real_escape_string($connection, $_POST['taskname']);
        $taskdescription = mysqli_real_escape_string($connection, $_POST['taskdescription']);
        $duedate = mysqli_real_escape_string($connection, $_POST['duedate']);

        $checkSql = "SELECT * FROM tblTask WHERE taskname = '$taskname'";
        $checkResult = mysqli_query($connection, $checkSql);
        $checkRow = mysqli_fetch_assoc($checkResult);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "<script>alert('Task name already exists. Please choose a different name.');</script>";
        } else {
            $sql = "INSERT INTO tblTask(taskname, taskdescription, duedate) VALUES ('$taskname', '$taskdescription', '$duedate')";
            mysqli_query($connection, $sql);
        }
    }

    if (isset($_POST['btnDelete'])) {
        $taskid = mysqli_real_escape_string($connection, $_POST['taskID']);

        $sql = "DELETE FROM tblTask WHERE taskID = '$taskid'";
        mysqli_query($connection, $sql);
    }

    $sql = "SELECT * FROM tbluseraccount";
    $result = mysqli_query($connection, $sql);
    $total_user_accounts = mysqli_num_rows($result);

    $sql = "SELECT AVG(LENGTH(username)) as average_userlength FROM tbluseraccount";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $average_userlength = $row['average_userlength'];

    $sql = "SELECT * FROM tblTask";
    $result = mysqli_query($connection, $sql);
    $total_task = mysqli_num_rows($result);

    $sql = "SELECT AVG(LENGTH(taskdescription)) as average_desclength FROM tblTask";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $average_desclength = $row['average_desclength'];

    $sql = "SELECT COUNT(*) as total_tasks FROM (
        SELECT 'Deleted' as status, taskname, taskdescription, taskdate FROM tbltaskdeleted
        UNION ALL
        SELECT 'Ongoing' as status, taskname, taskdescription, taskdate FROM tblTask
        ORDER BY taskdate
      ) AS tasks";

    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_tasks = $row['total_tasks']; 

    $sql = "SELECT COUNT(*) as ongoing_tasks FROM tblTask";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $ongoing_tasks = $row['ongoing_tasks'];

    $sql = "SELECT COUNT(*) as deleted_tasks FROM tbltaskdeleted";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $deleted_tasks = $row['deleted_tasks'];

    $sql1 = "SELECT AVG(LENGTH(taskdescription)) as avg_ongoing_desclength FROM tblTask";
    $result1 = mysqli_query($connection, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $avg_ongoing_desclength = $row1['avg_ongoing_desclength'];

    $sql2 = "SELECT AVG(LENGTH(taskdescription)) as avg_deleted_desclength FROM tbltaskdeleted";
    $result2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $avg_deleted_desclength = $row2['avg_deleted_desclength'];

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
                                    $sql = "SELECT tbluseraccount.acctid, tbluserprofile.userid, tbluseraccount.emailadd, tbluserprofile.firstname, tbluserprofile.lastname, tbluseraccount.username FROM tbluseraccount JOIN tbluserprofile ON tbluseraccount.acctid = tbluserprofile.acctid";
                                    $result = mysqli_query($connection, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['emailadd'] . "</td>";
                                        echo "<td>" . $row['firstname'] . "</td>";
                                        echo "<td>" . $row['lastname'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td colspan='4'>Total number of Users: $total_user_accounts</td></tr>";
                                    echo "<tr><td colspan='4'>Average length of Usernames: ".round($average_userlength, 3)." </td></tr>";
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
                                    $sql = "SELECT 'Deleted' as status, taskname, taskdescription, taskdate FROM tbltaskdeleted
                                            UNION ALL
                                            SELECT 'Ongoing' as status, taskname, taskdescription, taskdate FROM tblTask
                                            ORDER BY taskdate";
                                    $result = mysqli_query($connection, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>". $row['status']. "</td>";
                                        echo "<td>". $row['taskname']. "</td>";
                                        echo "<td>". $row['taskdescription']. "</td>";
                                        echo "<td>". $row['taskdate']. "</td>";
                                        echo "</tr>";
                                    }   
                                    echo "<tr><td colspan='4'>Number of Ongoing Tasks: $ongoing_tasks</td></tr>";
                                    echo "<tr><td colspan='4'>Number of Deleted Tasks: $deleted_tasks</td></tr>";
                                    echo "<tr><td colspan='4'>Total number of Tasks: $total_tasks</td></tr>";
                                    echo "<tr><td colspan='4'>Average length of task description of Deleted and Ongoing Tasks: ".round($sum_of_averages, 3)."</td></tr>";
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
                                    $sql = "SELECT taskid, taskname, taskdescription, taskdate FROM tblTask";
                                    $result = mysqli_query($connection, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>". $row['taskname']. "</td>";
                                        echo "<td>". $row['taskdescription']. "</td>";
                                        echo "<td>". $row['taskdate']. "</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr><td colspan='4'>Total number of Tasks: $total_task</td></tr>";
                                    echo "<tr><td colspan='4'>Average length of Task Description: ".round($average_desclength, 3)." </td></tr>";
                                ?>
                            </table>
                        </div>
                    </div>
					
					<br/>
					
                </div>
            </div>
        </body>
    </html>