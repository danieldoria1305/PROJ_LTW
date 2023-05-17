document.addEventListener("DOMContentLoaded", function () {
  var departmentFilter = document.getElementById("department-filter");
  var statusFilter = document.getElementById("status-filter");
  var priorityFilter = document.getElementById("priority-filter");
  var filterButton = document.getElementById("filter");
  var undoFilterButton = document.getElementById("undo-filter");

  // Add event listener to the filter button
  filterButton.addEventListener("click", function () {
    filterTickets();
  });

  // Add event listener to the undo filter button
  undoFilterButton.addEventListener("click", function () {
    undoFilter();
  });

  function filterTickets() {
    var departmentValue =
      departmentFilter.options[departmentFilter.selectedIndex].value;
    var statusValue = statusFilter.options[statusFilter.selectedIndex].value;
    var priorityValue =
      priorityFilter.options[priorityFilter.selectedIndex].value;

    var tickets = document.getElementsByClassName("ticket");

    for (var i = 0; i < tickets.length; i++) {
      var ticket = tickets[i];
      var ticketDepartment = ticket.getAttribute("data-department");
      var ticketStatus = ticket.getAttribute("data-status");
      var ticketPriority = ticket.getAttribute("data-priority");

      var departmentMatch =
        departmentValue === "all" || departmentValue === ticketDepartment;
      var statusMatch = statusValue === "all" || statusValue === ticketStatus;
      var priorityMatch =
        priorityValue === "all" || priorityValue === ticketPriority;

      if (departmentMatch && statusMatch && priorityMatch) {
        ticket.style.display = "block";
      } else {
        ticket.style.display = "none";
      }
    }
  }



  function undoFilter() {
    departmentFilter.value = "all";
    statusFilter.value = "all";
    priorityFilter.value = "all";

    var tickets = document.getElementsByClassName("ticket");

    for (var i = 0; i < tickets.length; i++) {
      tickets[i].style.display = "block";
    }
  }
});
