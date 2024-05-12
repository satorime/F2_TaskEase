function changeContent() {
	var element = document.querySelector('.header-identifier');
	element.classList.add('image'); // Add class to change content to image
	element.style.backgroundColor = '#E7C51D'; // Change background color
	element.style.width = '140px'; // Adjust width according to your need
	element.style.border = '2px solid black'; // Adjust width according to your need
	element.style.height = '40px'; // Adjust height according to your need
  
	setTimeout(function() {
		resetContent(); 
	}, 100000);
}

function resetContent() {
	var element = document.querySelector('.header-identifier');
	element.classList.remove('image');
	element.style.backgroundColor = '#43161a'; 
	element.style.width = '190px';
	element.style.height = '45px';
	element.style.border = '0px';
}

window.onload = function() {
    function updateTime() {
        var date = new Date();
        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var displayDate = monthNames[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();
        var displayTime = date.toLocaleTimeString();
                
		document.getElementById('date').innerHTML = displayDate;
        document.getElementById('time').innerHTML = displayTime;
        setTimeout(updateTime, 1000);
    }
    
	updateTime();
};

function deleteTask(taskName) {
	if (confirm("Are you sure you want to delete this task?")) {
		window.location.href = "delete-task.php?taskName=" + encodeURIComponent(taskName);
	}
}