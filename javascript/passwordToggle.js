const passwordField = document.getElementById("password");
const passwordToggle = document.getElementById("password-toggle");

passwordToggle.addEventListener("click", () => {
  if (passwordField.type === "password") {
    passwordField.type = "text";
    passwordToggle.textContent = "Hide";
  } else {
    passwordField.type = "password";
    passwordToggle.textContent = "Show";
  }
});
