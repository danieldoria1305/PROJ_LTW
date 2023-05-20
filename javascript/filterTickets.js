document.addEventListener("DOMContentLoaded", function () {
    var hashtagFilter = document.getElementById("hashtag-filter");
    var departmentFilter = document.getElementById("department-filter");
    var statusFilter = document.getElementById("status-filter");
    var priorityFilter = document.getElementById("priority-filter");
    var filterButton = document.getElementById("filter");
    var undoFilterButton = document.getElementById("undo-filter");

    filterButton.addEventListener("click", function () {
        filterTickets();
    });

    undoFilterButton.addEventListener("click", function () {
        undoFilter();
    });

    async function filterTickets() {
        var departmentValue = departmentFilter.options[departmentFilter.selectedIndex].value;
        var statusValue = statusFilter.options[statusFilter.selectedIndex].value;
        if (userRole !== "client") {
          var priorityValue = priorityFilter.options[priorityFilter.selectedIndex].value;
          var hashtagValue = hashtagFilter.options[hashtagFilter.selectedIndex].value;
          var hashtagName = await getHashtagNameByIdFromAPI(hashtagValue);
        }

        var tickets = document.getElementsByClassName("ticket");

        if (userRole === "client") {
          var priorityValue = "all";
          var hashtagValue = "all";
        }

        for (var i = 0; i < tickets.length; i++) {
            var ticket = tickets[i];
            var ticketDepartment = ticket.getAttribute("data-department");
            var ticketStatus = ticket.getAttribute("data-status");
            var ticketPriority = ticket.getAttribute("data-priority");
            var ticketHashtags = ticket.getAttribute("data-hashtags").split(", ");

            var departmentMatch = departmentValue === "all" || departmentValue === ticketDepartment;
            var statusMatch = statusValue === "all" || statusValue === ticketStatus;
            var priorityMatch = priorityValue === "all" || priorityValue === ticketPriority;
            var hashtagMatch = hashtagValue === "all" || ticketHashtags.includes(hashtagName);

            if (departmentMatch && statusMatch && priorityMatch && hashtagMatch) {
                ticket.style.display = "block";
            } else {
                ticket.style.display = "none";
            }
      }
    }

    function getHashtagNameByIdFromAPI(id) {
        return fetch("../api/hashtagsApi.php?id=" + id)
            .then((response) => response.json())
            .then((data) => data)
            .catch((error) => {
                console.error("Error retrieving hashtag name:", error);
                return "";
        });
    }

    function undoFilter() {
        departmentFilter.value = "all";
        statusFilter.value = "all";
        if (userRole !== "client"){
            hashtagFilter.value = "all";
            priorityFilter.value = "all";
        }

        var tickets = document.getElementsByClassName("ticket");

        for (var i = 0; i < tickets.length; i++) {
            tickets[i].style.display = "block";
        }
    }
});
