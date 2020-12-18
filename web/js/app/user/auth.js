function login(url) {
  let formdata = getFormData(url);
  $.post(
    url,
    formdata,
    responceResult
  );
  
}
function getFormData(url) {
  
  let data = {
    _csrf: $('[name="_csrf"]').val(),
    LoginForm: {
      pin: $('#pin').val(),
      password: $('#password').val(),
    },
  };
  if (url == '/site/sign-up') {
    data = {
      _csrf: $('[name="_csrf"]').val(),
      SignupForm: {
        pin: $('#pin').val(),
        password: $('#password').val(),
      },
    };
  }
  return data;
}
function responceResult(data) {
  console.log(data);
  errors(data);
}


$(document).ready(function () { 
    $('.toastrDefaultError').click(function() {
      login('/site/login');
    });
    $('.toastrDefaultErrorSignUp').click(function() {
      login('/site/sign-up');
    });
    $('form').on('submit', function(event) {
      event.preventDefault();
    });
});
