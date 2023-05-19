$(document).ready(function () {
  $(".role-form").submit(function (event) {
    event.preventDefault();

    var form = $(this);
    var agentId = form.data("agent-id");
    var roleSelect = form.find(".role-select");
    var selectedRole = roleSelect.val();

    $.ajax({
      url: "../actions/action_editRole.php",
      type: "POST",
      data: {
        clientId: agentId,
        role: selectedRole,
      },
      success: function (response) {
        console.log(response);
      },
      error: function (error) {
        console.log(error);
      },
    });
  });

  $(".department-form").submit(function (event) {
    event.preventDefault();

    var form = $(this);
    var agentId = form.data("agent-id");
    var departmentSelect = form.find(".department-select");
    var selectedDepartment = departmentSelect.val();

    $.ajax({
      url: "../actions/action_editDepartment.php",
      type: "POST",
      data: {
        clientId: agentId,
        departmentId: selectedDepartment,
      },
      success: function (response) {
        console.log(response);
      },
      error: function (error) {
        console.log(error);
      },
    });
  });
});
