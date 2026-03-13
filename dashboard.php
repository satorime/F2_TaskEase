<?php
ob_start();
include 'connect.php';

/* ── toast helper ── */
$toast = "<script>
(function(){
  var t = document.createElement('div');
  t.style.cssText = 'position:fixed;top:1.5rem;left:50%;transform:translateX(-50%);background:#2d2d2d;color:#fff;padding:.75rem 1.5rem;border-radius:8px;font-family:Patrick Hand,cursive;font-size:1rem;z-index:9999;box-shadow:4px 4px 0 #000;';
  t.textContent = 'Done! ✓';
  document.body.appendChild(t);
  setTimeout(()=>t.remove(),1500);
  setTimeout(()=>location.href='dashboard.php',800);
})();
</script>";

/* ── btnCreate ── */
if (isset($_POST['btnCreate'])) {
    $important       = $_POST['important'];
    $taskname        = $_POST['taskname'];
    $taskdescription = $_POST['taskdescription'];
    $taskdate        = $_POST['taskdate'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbltask WHERE taskname = :taskname");
    $stmt->execute([':taskname' => $taskname]);
    $exists = $stmt->fetchColumn();

    if ($exists > 0) {
        echo "<script>alert('Task name already exists.');</script>";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO tbltask (taskname, taskdescription, taskdate, isimportant)
             VALUES (:taskname, :taskdescription, :taskdate, :isimportant)"
        );
        $stmt->execute([
            ':taskname'        => $taskname,
            ':taskdescription' => $taskdescription,
            ':taskdate'        => $taskdate,
            ':isimportant'     => $important,
        ]);
        echo $toast;
    }
}

/* ── btnUpdate ── */
if (isset($_POST['btnUpdate'])) {
    $taskname        = $_POST['taskname'];
    $taskdate        = $_POST['taskdate'];
    $taskdescription = $_POST['taskdescription'];

    $stmt = $pdo->prepare(
        "UPDATE tbltask SET taskname = :taskname, taskdate = :taskdate,
         taskdescription = :taskdescription WHERE taskname = :taskname"
    );
    $result = $stmt->execute([
        ':taskname'        => $taskname,
        ':taskdate'        => $taskdate,
        ':taskdescription' => $taskdescription,
    ]);
    if ($result) echo $toast;
}

/* ── fetch tasks ── */
$allTasks     = $pdo->query("SELECT * FROM tbltask ORDER BY taskdate ASC")->fetchAll();
$importantTasks = $pdo->query("SELECT * FROM tbltask WHERE isimportant = 1 ORDER BY taskdate ASC")->fetchAll();
$deletedTasks = $pdo->query("SELECT * FROM tbltaskdeleted WHERE is_active = 1 ORDER BY deleted_date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TaskEase — Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/hand-drawn.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="js/redirect-pages.js"></script>
  <script src="js/format-pages.js" defer></script>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar-brand" onclick="redirectToIndex()">
      <img src="images/taskeaseLogo2.png" alt="TaskEase">
      <span class="navbar-brand-name">TaskEase</span>
    </div>
    <div class="navbar-links">
      <span class="nav-link" onclick="redirectToIndex()">Home</span>
      <span class="nav-link" onclick="redirectToAboutus()">About</span>
      <span class="nav-link" onclick="redirectToContactus()">Contact</span>
      <span class="nav-link primary" onclick="redirectToProfile()">Reports</span>
      <a class="nav-link" href="#modal-search">🔍</a>
      <a class="nav-link primary" href="#modal-more">⚙️ More</a>
    </div>
  </nav>

  <!-- Main -->
  <div class="dash-wrapper">

    <!-- Header -->
    <div class="dash-header">
      <h1 class="dash-title">📋 My Tasks</h1>
      <div class="dash-meta">
        <span id="date"></span><br>
        <span id="time"></span>
      </div>
    </div>

    <!-- Tab system — radios, labels, panels must all be siblings -->
    <div class="tabs-wrap">
      <input type="radio" id="tab-all"       name="sec-a" checked>
      <input type="radio" id="tab-important" name="sec-a">
      <input type="radio" id="tab-deleted"   name="sec-a">

      <div class="tab-labels">
        <label for="tab-all"       class="tab-label">📁 All Tasks</label>
        <label for="tab-important" class="tab-label">⭐ Important</label>
        <label for="tab-deleted"   class="tab-label">🗑️ Recently Deleted</label>
      </div>

      <!-- ── ALL TASKS ── -->
      <div class="tab-panel panel-all">
        <div class="panel-heading">
          <h2 class="panel-title">All Tasks</h2>
          <span class="panel-sub">sorted newest → oldest</span>
        </div>
        <hr class="dashed">
        <div class="task-grid">
          <?php if (count($allTasks) > 0): ?>
            <?php foreach ($allTasks as $row): ?>
              <div class="task-card <?php echo $row['isimportant'] == 1 ? 'card-important' : ''; ?>">
                <div class="task-name"><?php echo htmlspecialchars($row['taskname']); ?></div>
                <div class="task-desc"><?php echo htmlspecialchars($row['taskdescription']); ?></div>
                <div class="task-date">📅 <?php echo htmlspecialchars($row['taskdate']); ?></div>
                <div class="task-actions">
                  <a class="btn btn-blue btn-sm" href="#view-<?php echo $row['taskid']; ?>">View</a>
                  <a class="btn btn-danger btn-sm"
                     href="delete-task.php?taskName=<?php echo urlencode($row['taskname']); ?>"
                     onclick="return confirm('Move to trash?')">Delete</a>
                </div>
              </div>

              <!-- View / Edit Modal -->
              <div id="view-<?php echo $row['taskid']; ?>" class="overlay">
                <div class="modal">
                  <h2 class="modal-title">✏️ Edit Task</h2>
                  <a class="modal-close" href="#">×</a>
                  <form action="#" method="post">
                    <input type="hidden" name="taskID" value="<?php echo htmlspecialchars($row['taskid']); ?>">

                    <div class="star-row">
                      <img src="<?php echo $row['isimportant'] == 1 ? 'images/starfilled.png' : 'images/starhollow.png'; ?>"
                           id="statusImage-<?php echo $row['taskid']; ?>"
                           class="star-toggle"
                           onclick="toggleStar(this, 'imp-<?php echo $row['taskid']; ?>')">
                      <input type="hidden" id="imp-<?php echo $row['taskid']; ?>" name="important"
                             value="<?php echo $row['isimportant']; ?>">
                    </div>

                    <div class="field-wrap">
                      <label>Task Name</label>
                      <input class="input-field" type="text" name="taskname"
                             value="<?php echo htmlspecialchars($row['taskname']); ?>" required>
                    </div>

                    <div class="field-wrap">
                      <label>Due Date</label>
                      <input class="input-field datepicker" type="text" name="taskdate"
                             value="<?php echo htmlspecialchars($row['taskdate']); ?>" required>
                    </div>

                    <div class="field-wrap">
                      <label>Description</label>
                      <input class="input-field" type="text" name="taskdescription"
                             value="<?php echo htmlspecialchars($row['taskdescription']); ?>" required>
                    </div>

                    <button class="btn btn-primary" type="submit" name="btnUpdate"
                            onclick="return confirm('Save changes?')" style="width:100%;">
                      Save Changes
                    </button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="task-empty">
              <img src="images/notasks.png" alt="No tasks">
              <p>No tasks yet — hit + to create one!</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- ── IMPORTANT ── -->
      <div class="tab-panel panel-important">
        <div class="panel-heading">
          <h2 class="panel-title">Important Tasks</h2>
          <span class="panel-sub">sorted newest → oldest</span>
        </div>
        <hr class="dashed">
        <div class="task-grid">
          <?php if (count($importantTasks) > 0): ?>
            <?php foreach ($importantTasks as $row): ?>
              <div class="task-card card-important">
                <div class="task-name"><?php echo htmlspecialchars($row['taskname']); ?></div>
                <div class="task-desc"><?php echo htmlspecialchars($row['taskdescription']); ?></div>
                <div class="task-date">📅 <?php echo htmlspecialchars($row['taskdate']); ?></div>
                <div class="task-actions">
                  <a class="btn btn-blue btn-sm" href="#imp-view-<?php echo $row['taskid']; ?>">View</a>
                  <a class="btn btn-danger btn-sm"
                     href="delete-task.php?taskName=<?php echo urlencode($row['taskname']); ?>"
                     onclick="return confirm('Move to trash?')">Delete</a>
                </div>
              </div>

              <div id="imp-view-<?php echo $row['taskid']; ?>" class="overlay">
                <div class="modal">
                  <h2 class="modal-title">⭐ Edit Important Task</h2>
                  <a class="modal-close" href="#">×</a>
                  <form action="#" method="post">
                    <div class="field-wrap">
                      <label>Task Name</label>
                      <input class="input-field" type="text" name="taskname"
                             value="<?php echo htmlspecialchars($row['taskname']); ?>" required>
                    </div>
                    <div class="field-wrap">
                      <label>Due Date</label>
                      <input class="input-field datepicker" type="text" name="taskdate"
                             value="<?php echo htmlspecialchars($row['taskdate']); ?>" required>
                    </div>
                    <div class="field-wrap">
                      <label>Description</label>
                      <input class="input-field" type="text" name="taskdescription"
                             value="<?php echo htmlspecialchars($row['taskdescription']); ?>" required>
                    </div>
                    <button class="btn btn-primary" type="submit" name="btnUpdate"
                            style="width:100%;">Save Changes</button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="task-empty">
              <img src="images/nofav.png" alt="No important tasks">
              <p>No important tasks yet — star one!</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- ── DELETED ── -->
      <div class="tab-panel panel-deleted">
        <div class="panel-heading">
          <h2 class="panel-title">Recently Deleted</h2>
          <span class="panel-sub">sorted newest → oldest</span>
        </div>
        <hr class="dashed">
        <div class="task-grid">
          <?php if (count($deletedTasks) > 0): ?>
            <?php foreach ($deletedTasks as $row): ?>
              <div class="task-card card-deleted">
                <div class="task-name"><?php echo htmlspecialchars($row['taskname']); ?></div>
                <div class="task-desc"><?php echo htmlspecialchars($row['taskdescription']); ?></div>
                <div class="task-date">📅 <?php echo htmlspecialchars($row['taskdate']); ?></div>
                <div class="task-actions">
                  <a class="btn btn-blue btn-sm"
                     href="restore-task.php?taskName=<?php echo urlencode($row['taskname']); ?>"
                     onclick="return confirm('Restore this task?')">Restore</a>
                  <a class="btn btn-danger btn-sm"
                     href="perm-delete.php?taskName=<?php echo urlencode($row['taskname']); ?>"
                     onclick="return confirm('Permanently delete?')">Remove</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="task-empty">
              <img src="images/recycle.png" alt="Trash empty">
              <p>Trash is empty.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div><!-- /tabs-wrap -->
  </div><!-- /dash-wrapper -->

  <!-- FAB -->
  <a class="fab" href="#modal-create" title="New Task">+</a>

  <!-- ── CREATE TASK MODAL ── -->
  <div id="modal-create" class="overlay">
    <div class="modal">
      <h2 class="modal-title">✏️ Create a Task</h2>
      <a class="modal-close" href="#">×</a>
      <form action="#" method="post">
        <div class="star-row">
          <img src="images/starhollow.png" id="statusImage" class="star-toggle"
               onclick="changeImage()">
          <input type="hidden" id="importantInput" name="important" value="0">
          <span style="font-size:0.85rem; color:rgba(45,45,45,0.5); margin-left:0.5rem;">Mark as important</span>
        </div>

        <div class="field-wrap">
          <label>Task Name</label>
          <input class="input-field" type="text" name="taskname" placeholder="e.g. Finish report" required>
        </div>

        <div class="field-wrap">
          <label>Due Date</label>
          <input class="input-field datepicker" type="text" name="taskdate" placeholder="mm-dd-yyyy" required>
        </div>

        <div class="field-wrap">
          <label>Description</label>
          <input class="input-field" type="text" name="taskdescription" placeholder="What needs to be done?" required>
        </div>

        <button class="btn btn-primary" type="submit" name="btnCreate" style="width:100%;">
          Create Task →
        </button>
      </form>
    </div>
  </div>

  <!-- ── SEARCH MODAL ── -->
  <div id="modal-search" class="overlay">
    <div class="modal">
      <h2 class="modal-title">🔍 Search Tasks</h2>
      <a class="modal-close" href="#">×</a>
      <input class="input-field" type="text" id="searchInput" placeholder="Enter task title…">
      <button class="btn btn-primary" onclick="search()" style="width:100%;margin-top:0.5rem;">Search</button>
      <div id="searchResults" style="margin-top:1rem;"></div>
    </div>
  </div>

  <!-- ── MORE / LOGOUT MODAL ── -->
  <div id="modal-more" class="overlay">
    <div class="modal" style="max-width:320px; text-align:center;">
      <h2 class="modal-title">⚙️ Settings</h2>
      <a class="modal-close" href="#">×</a>
      <button class="btn btn-danger" onclick="logout()" style="width:100%;">Log Out</button>
    </div>
  </div>

  <script>
    $(document).ready(function(){
      $('.datepicker').datepicker({ format: 'mm-dd-yyyy', autoclose: true });
    });

    function changeImage() {
      var img = document.getElementById("statusImage");
      var inp = document.getElementById("importantInput");
      if (img.src.includes("starhollow.png")) {
        img.src = "images/starfilled.png";
        inp.value = "1";
      } else {
        img.src = "images/starhollow.png";
        inp.value = "0";
      }
    }

    function toggleStar(img, inputId) {
      var inp = document.getElementById(inputId);
      if (img.src.includes("starhollow.png")) {
        img.src = "images/starfilled.png";
        inp.value = "1";
      } else {
        img.src = "images/starhollow.png";
        inp.value = "0";
      }
    }
  </script>

</body>
</html>
