/**
 *
 * AuthLogin
 *
 * Pages.Authentication.Login page content scripts. Initialized from scripts.js file.
 *
 *
 */

class AuthLogin {
  constructor() {
    // Initialization of the page plugins
    this._initForm();
  }

  // Form validation
  _initForm() {
    const form = document.getElementById('loginForm');
    if (!form) {
      return;
    }
    const validateOptions = {
      rules: {
        email: {
          required: true,
          email: true,
        },
      },
      messages: {
        email: {
          email: 'Your email address must be in correct format!',
        },
      },
    };
    $(form).validate(validateOptions);
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if ($(form).valid()) {
        const formValues = {
          email: form.querySelector('[name="Usuario"]').value,
          password: form.querySelector('[name="password"]').value,
        };
        $.ajax({
          url: 'Controller/Login.php',
          method: 'POST',
          dataType: 'html',
          data: {username:$("#user").val(), password:$("#pass").val()},
          beforeSend: function(data) {
            $('.loader').removeAttr('hidden');
          },
          success: function(data) {
          },
          error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
              msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
              msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
              msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
              msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
              msg = 'Time out error.';
            } else if (exception === 'abort') {
              msg = 'Ajax request aborted.';
            } else {
              msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            alert(msg);
          },
        return;
      }
    });
  }
}
