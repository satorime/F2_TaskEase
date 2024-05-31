<?php
    include 'connect.php';   
?>
 
<html>
    <head>
        <title> TaskEase - Dashboard </title>
		<!-- calendar bootstrap -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        
		<link rel="stylesheet" href="css/dashboard1.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&display=swap">
        <script src="js/redirect-pages.js"></script>
        <script src="js/format-pages.js" defer></script>

        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    </head>
   
    <body>
        <div class="page-header">
            <div class="header-logo">
                <div>
                    <img src = "images/taskeaseLogo2.png" />
                </div>
               
                <div class="button-name">
                    <span> TASKEAS</span>E
                </div>
            </div>
           
            <hr class="divider-line"/>
           
            <div class="button-logo" id="button-hover" onclick="redirectToIndex();">
                <div>
                    <img src = "images/home.png" />
                </div>
               
                <div class="button-name">
                    <span> HOM</span>E
                </div>
            </div>
           
            <div class="button-logo" id="button-hover" onclick="redirectToAboutus();">
                <div>
                    <img src = "images/about.png" />
                </div>
               
                <div class="button-name">
                    <span> ABOUT<br/>U</span>S
                </div>
            </div>
           
            <div class="button-logo" id="button-hover" onclick="redirectToContactus();">
                <div>
                    <img src = "images/contact.png" />
                </div>
               
                <div class="button-name">
                    <span> CONTACT<br/>U</span>S
                </div>
            </div>
           
            <hr class="divider-line"/>
           
            <div class="button-logo">
                <a class="button" href="#popup1">
                    <div>
                        <img src = "images/search.png" />
                    </div>
                   
                    <div class="button-name">
                         <span> SEARC</span>H
                    </div>
                </a>
               
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <h2> Navigate through TaskEase </h2>
                        <a class="close" href="#">&times;</a>
                        <div class="content">
                            <input type="text" id="searchInput" placeholder="Enter the task title.">
                            <button onclick="search()">SEARCH</button>
                            <div id="searchResults"></div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="button-logo" id="button-hover" onclick="redirectToProfile();">
                <div>
                    <img src = "images/profile.png" />
                </div>
               
                <div class="button-name">
                    <span> REPOR</span>T
                </div>
            </div>
           
            <div class="button-logo">
                <a class="button" href="#popup2">
                    <div>
                        <img src = "images/more.png" />
                    </div>
                   
                    <div class="button-name">
                         <span> MOR</span>E
                    </div>
                </a>
               
                <div id="popup2" class="overlay">
                    <div class="popup">
                        <h2> MORE SETTINGS </h2>
                        <a class="close" href="#">&times;</a>
                        <div class="content">
                            <button onclick="logout()">LOGOUT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
               
		<div class="add-task">
			<a class="add-button" href="#popup3">
				<span class="add-sign"> + </span>          
			</a>
			<div id="popup3" class="overlay">
				<div class="popup">
					<h2> CREATE A TASK </h2>
					<hr/>
					<a class="close" href="#">&times;</a>
					<div class="add-content">
						<form action="#" method="post">							
							<div class="status" id="statuschange" name="createStatus">
								<img src="images/starhollow.png" id="statusImage" onclick="changeImage()">
								<input type="hidden" id="importantInput" name="important" value="0">
							</div>

							<div class="field">
								<input type="text" name="taskname" required>
								<label>Task Name</label>
							</div>
						   
							<div class="field">
								<input type="text" name="taskdate" class="datepicker" required>
								<label>Date of Completion</label>
							</div>
						   
							<div class="desc-field">
								<input type="text" name="taskdescription" required>
								<label>Task Description</label>
							</div>
						   
							<div class="field">
								<div class="create">
									<input type="submit" value="CREATE" name="btnCreate">
								</div>
							</div>
						 </form>
					</div>
				</div>
			</div>
		</div>
                   
        <div class="dashboard">
            <div class="dashboard-header">
                <div class="header-title-group">
                    <div class="header-title">
                        <span> WELCOME , USER!</span>
                    </div>
                   
                    <div class="lower-header">
                        <div>
                            <hr/>
                        </div>
                        <span> LET'S START YOUR DAY CREATING A TASK </span>
                    </div>
                </div>
               
                <div id="datetime">
                    <span id="date"></span><br>
                    <span id="time"></span>
                </div>
            </div>
               
            <div class="body-section">
                <input type="radio" id="all-tab" name="sec-a" checked="checked">
                <label for="all-tab" class="section-all">
                    <div>
                        <img src="images/all.png">
                    </div>
                       
                    <div>
                        <span> All Tasks </span>
                    </div>
                </label>
                <div class="all-content">
                    <div class="section-header">
                        <h2> ALL TASKS </h2>
                        <h5> Sorted by: Newest to Oldest </h5>
                    </div>
                    <hr/>
                    <div class="no-alltasks">
                    
					<?php
						$sql = "SELECT * FROM tbltask ORDER BY taskdate ASC";
						$result = mysqli_query($connection, $sql);
						$count = 0;
						
						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
                                $taskname=$row['taskname'];
								if ($count % 4 == 0) {
									echo "<br>";
								}
					?>
								<table class="task-table">
									<tr class="task-format">
										<td class="task-name"><?php echo $row["taskname"]; ?></td>
										<td class="task-desc"><?php echo $row["taskdescription"]; ?></td>
										<td class="task-date"><?php echo $row["taskdate"]; ?></td>
										<td class="task-button">
											<a class="view-button" href="#popup4">
												<button class="func-button" onclick="viewTask('<?php echo $row["taskname"]; ?>')">View</button>
											</a>

											<div id="popup4" class="overlay">
												<div class="popup">
													<h2> VIEW A TASK </h2>
													<hr/>
													<a class="close" href="#">&times;</a>
													<div class="add-content">
														<form action="#" method="post">
															<input type="hidden" name="taskID" value="<?php echo $row["taskID"]; ?>">
															
															<div class="status" id="statuschange">
																<?php if ($row["isimportant"] == 1) {?>
																	<img src="images/starfilled.png" id="statusImage" onclick="changeImage()">
																<?php } else {?>
																	<img src="images/starhollow.png" id="statusImage" onclick="changeImage()">
																<?php }?>
															</div>
															
															<div class="field">
																<input type="text" name="taskname" value="<?php echo $row["taskname"]; ?>" required>
																<label>Task Name</label>
															</div>

															<div class="field">
																<input type="text" name="taskdate" value="<?php echo $row["taskdate"]; ?>" required>
																<label>Date of Completion</label>
															</div>

															<div class="desc-field">
																<input type="text" name="taskdescription" value="<?php echo $row["taskdescription"]; ?>" required>
																<label>Task Description</label>
															</div>

															<div class="field">
																<input type="submit" value="UPDATE" name="btnUpdate" onclick="if (!confirm('Are you sure?')) { return false }">
															</div>
														</form>
													</div>
												</div>
											</div>
															
											<a href="delete-task.php?taskName=<?php echo urlencode($row["taskname"]);?>" class="func-button" onclick="if (!confirm('Are you sure?')) { return false }">
												<button class="func-button"> Delete </button>
											</a>
										</td>
									</tr>
								</table>
					<?php
								
							}
						} else {
					?>
							<div>
								<img src="images/notasks.png">
							</div>
							<div>
								<span> There are currently no newly created task/s as of the moment. </span>
							</div>
					<?php
						}
					?>

					</div>
                </div>
                   
                <input type="radio" id="important-tab" name="sec-a">
                <label for="important-tab" class="section-important">
                    <div>
                        <img src="images/important.png">
                    </div>
                       
                    <div>
                        <span> Important Tasks </span>
                    </div>
                </label>
                <div class="all-content">
                    <div class="section-header">
                        <h2> IMPORTANT TASKS </h2>
                        <h5> Sorted by: Newest to Oldest </h5>
                    </div>
                    <hr/>
                    <div class="no-alltasks">
                    <?php
						$sql = "SELECT * FROM tbltask where isimportant =1 ORDER BY taskdate ASC";
						$result = mysqli_query($connection, $sql);
						$count = 0; // Initialize a counter

						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
                                $taskname=$row['taskname'];
								$count++;
								if ($count % 4 == 0) {
									echo "<br>";
								}
					?>
								<div class="task-table">
									<div class="task-format">
										<div class="task-name"><?php echo $row["taskname"]; ?></div>
										<div class="task-desc"><?php echo $row["taskdescription"]; ?></div>
										<div class="task-date"><?php echo $row["taskdate"]; ?></div>
										<div class="task-button">
											<a class="view-button" href="#popup5">
												<button class="func-button" onclick="viewTask('<?php echo $row["taskname"]; ?>')">View</button>
											</a>
											<div id="popup5" class="overlay">
												<div class="popup">
													<h2> VIEW A TASK </h2>
													<hr/>
													<a class="close" href="#">&times;</a>
													<div class="add-content">
														<form action="#" method="post">
															<input type="hidden" name="taskname" value="<?php echo $row["taskname"]; ?>">
															<div class="status" id="statuschange">
																<img src="images/starfilled.png" id="statusImage" onclick="changeImage()">
															</div>
															
															<div class="field">
																<input type="text" name="taskname" value="<?php echo $row["taskname"]; ?>" required>
																<label>Task Name</label>
															</div>

															<div class="field">
																<input type="text" name="taskdate" value="<?php echo $row["taskdate"]; ?>" required>
																<label>Date of Completion</label>
															</div>

															<div class="desc-field">
																<input type="text" name="taskdescription" value="<?php echo $row["taskdescription"]; ?>" required>
																<label>Task Description</label>
															</div>

															<div class="field">
																<input type="submit" value="UPDATE" name="btnUpdate">
															</div>
														</form>
													</div>
												</div>
											</div>
															
											<a href="delete-task.php?taskName=<?php echo urlencode($row["taskname"]); ?>" class="func-button">
												<button class="func-button"> Delete </button>
											</a>
										</div>
									</div>
								</div>
					<?php
								
							}
						} else {
					?>
                        <div>
                            <img src="images/nofav.png">
                        </div>
						
                        <div>

                            <span> There are currently no newly important<br/>task/s as of the moment. </span>
                        </div>
					<?php
						}
					?>
                    </div>
                </div>
                   
                <input type="radio" id="deleted-tab" name="sec-a">
                <label for="deleted-tab" class="section-deleted">
                    <div>
                        <img src="images/deleted.png">
                    </div>
                       
                    <div>
                        <span> Recently Deleted </span>
                    </div>
                </label>
                <div class="all-content">
                    <div class="section-header">
                        <h2> RECENTLY DELETED </h2>
                        <h5> Sorted by: Newest to Oldest </h5>
                    </div>
                    <hr/>
                    <div class="no-alltasks">
                        <div class="deleted-content">
                    <?php
                    $sql = "SELECT * FROM tbltaskdeleted WHERE is_active=1 ORDER BY deleted_date DESC";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <table class="task-table">
                                <tr class="task-format">
                                    <td class="task-name"><?php echo $row["taskname"]; ?></td>
                                    <td class="task-desc"><?php echo $row["taskdescription"]; ?></td>
                                    <td class="task-date"><?php echo $row["taskdate"]; ?></td>
                                    <td class="task-button">
										<a class="view-button" href="#popup9">
											<a href="restore-task.php?taskName=<?php echo urlencode($row["taskname"]); ?>" class="func-button" onclick="if (!confirm('Are you sure?')) { return false }">
											                <button class="func-button"> Restore </button>
										</a>

										<div id="popup9" class="overlay">
											<div class="popup">
												<h2> VIEW A DELETED TASK </h2>
												<hr/>
												<a class="close" href="#">&times;</a>
												<div class="add-content">
													<form action="#" method="post">
														<input type="hidden" name="taskname" value="<?php echo $row["taskname"]; ?>">
														<div class="status" id="statuschange">
															<button name = "btnStatus"><img src="images/starhollow.png" id="statusImage" onclick="changeImage()"></button>
														</div>
														
														<div class="field">
															<input type="text" name="taskname" value="<?php echo $row["taskname"]; ?>" required>
															<label>Task Name</label>
														</div>

														<div class="field">
															<input type="text" name="taskdate" value="<?php echo $row["taskdate"]; ?>" required>
															<label>Date of Completion</label>
														</div>

														<div class="desc-field">
															<input type="text" name="taskdescription" value="<?php echo $row["taskdescription"]; ?>" required>
															<label>Task Description</label>
														</div>

														<div class="field">
															</a>
														</div>
													</form>
												</div>
											</div>
										</div>

										<a href="perm-delete.php?taskName=<?php echo urlencode($row["taskname"]); ?>" class="func-button">
											<button class="func-button"> Remove </button>
										</a>
                                    </td>
                                </tr>
                            </table>
                    <?php
                        }
                    } else {
                    ?>
                        <div>
                            <img src="images/recycle.png">
                        </div>
                        <div>
                            <span> There are currently no deleted<br/>task/s as of the moment. </span>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


<?php
	$update_success = "<script language='javascript'>
			let errorMessage = document.createElement('div');
			errorMessage.style.cssText = 'display:flex; justify-content: center; align-content: center; position: absolute; top: 5vh; left: 50%; transform: translateX(-50%); background-color: darkgreen; color: white; padding: 20px; border-radius: 20px; width: auto; max-width: 500px; box-shadow: 0 0 13px 3px rgba(0, 0, 0, 0.5); ';
			errorMessage.classList.add('error-message');
			errorMessage.textContent = 'Task updated successfully!';
			document.body.appendChild(errorMessage);
			setTimeout(() => {
				document.body.removeChild(errorMessage);
			}, 1000);
			setTimeout(() => {
				window.location.href = 'dashboard.php';
			}, 500);
            </script>";

    $create_success = "<script language='javascript'>
			let errorMessage = document.createElement('div');
			errorMessage.style.cssText = 'display:flex; justify-content: center; align-content: center; position: absolute; top: 5vh; left: 50%; transform: translateX(-50%); background-color: darkgreen; color: white; padding: 20px; border-radius: 20px; width: auto; max-width: 500px; box-shadow: 0 0 13px 3px rgba(0, 0, 0, 0.5); ';
			errorMessage.classList.add('error-message');
			errorMessage.textContent = 'Task updated successfully!';
			document.body.appendChild(errorMessage);
			setTimeout(() => {
				document.body.removeChild(errorMessage);
			}, 1000);
			setTimeout(() => {
				window.location.href = 'dashboard.php';
			}, 500);
            </script>";
 
	if (isset($_POST['btnCreate'])) {
		$important = $_POST['important'];
     
		$taskname = mysqli_real_escape_string($connection, $_POST['taskname']);
		$taskdescription = mysqli_real_escape_string($connection, $_POST['taskdescription']);
		$taskdate = mysqli_real_escape_string($connection, $_POST['taskdate']);
		$checkSql = "SELECT * FROM tblTask WHERE taskname = '$taskname'";
		$checkResult = mysqli_query($connection, $checkSql);
		$checkRow = mysqli_fetch_assoc($checkResult);
		if (mysqli_num_rows($checkResult) > 0) {
			echo "<script>alert('Task name already exists. Please choose a different name.');</script>";
		} else {
            if(isset($important)){
    			$sql = "Insert into tblTask(taskname, taskdescription, taskdate, isimportant) values('$taskname', '$taskdescription', '$taskdate','$important')";
			mysqli_query($connection, $sql);
            echo $create_success;
            }else{
                $sql = "Insert into tblTask(taskname, taskdescription, taskdate,isimportant) values('$taskname', '$taskdescription', '$taskdate','$imporant')";
                mysqli_query($connection, $sql);
                echo $create_success;
            }
		}
	}
?>



<?php
	if (isset($_POST['btnUpdate'])) {
		$taskID = $_POST['taskID'];
		$taskname = $_POST['taskname'];
		$taskdate = $_POST['taskdate'];
		$taskdescription = $_POST['taskdescription'];
		
		$sql = "UPDATE tbltask SET taskname='$taskname', taskdate='$taskdate', taskdescription='$taskdescription' WHERE taskname='$taskname'";
		$result = mysqli_query($connection, $sql);
		if ($result) {
			echo $update_success;
		} else {
			echo "Error updating task: ". mysqli_error($connection);
		}
	}
?>

<script>
	$(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'mm-dd-yyyy',
			autoclose: true
		});
	});
  
	function changeImage() {
    var statusImage = document.getElementById("statusImage");
    var importantInput = document.getElementById("importantInput");
    if (statusImage.src.includes("starhollow.png")) {
        statusImage.src = "images/starfilled.png";
        importantInput.value = "1";
    } else {
        statusImage.src = "images/starhollow.png";
        importantInput.value = "0";
    	}
	}
</script>
