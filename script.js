function matchPassword() {
    var password = document.getElementById("password").value;
    var con_password = document.getElementById("con_password").value;
    if (password != con_password) {
      alert("Passwords do not match!");
      return false;
    }
    return true;
  }
  
  function showMessage() {
    // Show the message
    document.getElementById("message").style.display = "block";
    
    // Prevent the form from submitting
    event.preventDefault();
  }


  function validateUsername() {
    const usernameInput = document.getElementById('usernameInput');
    const usernameError = document.getElementById('usernameError');
  
    const username = usernameInput.value;
    if (username.length < 3 || username.length > 40) {
      usernameError.textContent = 'Username must be between 3 and 40 characters.';
    } else {
      usernameError.textContent = '';
    }
  }
  
  document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('usernameInput');
    usernameInput.addEventListener('input', validateUsername);
  });

  

  // window.addEventListener('load', function() {
  //   var successMessage = document.getElementById('success-message');
  //   if (successMessage) {
  //     setTimeout(function() {
  //       successMessage.style.display = 'none';
  //     }, 5000); // 5000 milliseconds = 5 seconds
  //   }
  // });
  


  


