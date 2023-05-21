document.addEventListener("DOMContentLoaded", function () {
  var roleForms = document.querySelectorAll(".role-form");
  roleForms.forEach(function (form) {
    form.addEventListener("submit", function (event) {
      event.preventDefault();

      var agentId = form.querySelector('input[name="clientId"]').value;
      var roleSelect = form.querySelector(".role-select");
      var selectedRole = roleSelect.value;

      fetch("../actions/action_editRole.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body:
          "clientId=" +
          encodeURIComponent(agentId) +
          "&role=" +
          encodeURIComponent(selectedRole),
      })
        .then(function (response) {
          if (response.ok) {
            console.log("Role updated successfully");
            window.location.href =
              selectedRole === "client"
                ? "../pages/listClients.php"
                : "../pages/listAgents.php";
          } else {
            console.log("Error updating role");
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    });
  });

  var departmentForms = document.querySelectorAll(".department-form");
  departmentForms.forEach(function (form) {
    form.addEventListener("submit", function (event) {
      event.preventDefault();

      var agentId = form.querySelector('input[name="clientId"]').value;
      var departmentSelect = form.querySelector(".department-select");
      var selectedDepartment = departmentSelect.value;

      fetch("../actions/action_editDepartment.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body:
          "clientId=" +
          encodeURIComponent(agentId) +
          "&departmentId=" +
          encodeURIComponent(selectedDepartment),
      })
        .then(function (response) {
          if (response.ok) {
            console.log("Department updated successfully");
            window.location.href = "../pages/listAgents.php";
          } else {
            console.log("Error updating department");
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    });
  });
});
