function showAddHashtag() {
    var hashtagForm = document.getElementById("new-hashtag-form");
    hashtagForm.style.display = "block";
    var ticketContainer = document.querySelector(".ticket-container");
    ticketContainer.classList.add("open-form");
}

function cancelAddHashtag() {
    var hashtagForm = document.getElementById("new-hashtag-form");
    hashtagForm.style.display = "none";
    var newHashtagInput = document.getElementById("new-hashtag-input");
    newHashtagInput.value = "";

    var statusForm = document.getElementById("new-status-form");
    var departmentForm = document.getElementById("new-department-form");
    if (
        (!statusForm.style.display || statusForm.style.display === "none") &&
        (!departmentForm.style.display || departmentForm.style.display === "none")
    ) {
        var ticketContainer = document.querySelector(".ticket-container");
        ticketContainer.classList.remove("open-form");
    }
}

function addHashtag() {
    var newHashtagInput = document.getElementById("new-hashtag-input");
    var newHashtag = newHashtagInput.value.trim();

    if (newHashtag !== "") {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            location.reload();
        }
        };
        xhttp.open("POST", "../actions/action_addHashtag.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("newHashtag=" + newHashtag);
    }
}


function showAddDepartment() {
    var departmentForm = document.getElementById("new-department-form");
    departmentForm.style.display = "block";
    var ticketContainer = document.querySelector(".ticket-container");
    ticketContainer.classList.add("open-form");
}

function cancelAddDepartment() {
    var departmentForm = document.getElementById("new-department-form");
    departmentForm.style.display = "none";
    var newDepartmentInput = document.getElementById("new-department-input");
    newDepartmentInput.value = "";

    var statusForm = document.getElementById("new-status-form");
    var hashtagForm = document.getElementById("new-hashtag-form");
    if (
        (!statusForm.style.display || statusForm.style.display === "none") &&
        (!hashtagForm.style.display || hashtagForm.style.display === "none")
    ) {
        var ticketContainer = document.querySelector(".ticket-container");
        ticketContainer.classList.remove("open-form");
    }
}

function addDepartment() {
    var newDepartmentInput = document.getElementById("new-department-input");
    var newDepartment = newDepartmentInput.value.trim();

    if (newDepartment !== "") {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            location.reload();
        }
        };
        xhttp.open("POST", "../actions/action_addDepartment.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("newDepartment=" + newDepartment);
    }
}


function showAddStatus() {
    var statusForm = document.getElementById("new-status-form");
    statusForm.style.display = "block";
    var ticketContainer = document.querySelector(".ticket-container");
    ticketContainer.classList.add("open-form");
}

function cancelAddStatus() {
    var statusForm = document.getElementById("new-status-form");
    statusForm.style.display = "none";
    var newStatusInput = document.getElementById("new-status-input");
    newStatusInput.value = "";

    var departmentForm = document.getElementById("new-department-form");
    var hashtagForm = document.getElementById("new-hashtag-form");
    if (
        (!departmentForm.style.display ||
        departmentForm.style.display === "none") &&
        (!hashtagForm.style.display || hashtagForm.style.display === "none")
    ) {
        var ticketContainer = document.querySelector(".ticket-container");
        ticketContainer.classList.remove("open-form");
    }
}

function addStatus() {
    var newStatusInput = document.getElementById("new-status-input");
    var newStatus = newStatusInput.value.trim();

    if (newStatus !== "") {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            location.reload();
        }
        };
        xhttp.open("POST", "../actions/action_addStatus.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("newStatus=" + newStatus);
    }
}
