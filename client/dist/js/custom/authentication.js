
function createAccount() {
  // immediately show disabled/processing button
  disabledBtn('btn btn-info btn-md w-100');

  let inp_email = $('#inp_email').val();
  let inp_name = $('#inp_name').val();
  let inp_company = $('#inp_company').val();
  let inp_password = $('#inp_password').val();
  let inp_confirm_password = $('#inp_confirm_password').val();

  let jso = {
    email: '' + inp_email + '',
    name: '' + inp_name + '',
    company_id: inp_company,
    password: '' + inp_password + '',
    confirm_password: ''+ inp_confirm_password +''
  };

  //make api request
  crudaction(jso, '/users/sign_up.php', 'POST', function (feed) {
    const { status, message } = feed;

    if (status) {
      //return the original button
      submitBtn('createAccount()', (classStyling = 'btn btn-outline-info w-100'));
    }

    toastNotification(status, message);

    if (status === 'Ok') {
      setTimeout(function () {
        gotourl('login');
      }, 2500);
    }
  });
}



function login() {
  //immediately show disabled/processing button
  disabledBtn('btn btn-info btn-md w-100');

  let inp_email = $('#inp_email').val();
  let inp_password = $('#inp_password').val();

  let jso = {
    email: '' + inp_email + '',
    password: '' + inp_password + '',
  };

  //make api request
  crudaction(jso, '/users/sign_in.php', 'POST', function (feed) {
    const { status, message } = feed;

    if (status) {
      //return the original button
      submitBtn('login()', (classStyling = 'btn btn-outline-info w-100'));
    }

    toastNotification(status, message);

    if (status === 'Ok') {
      setTimeout(function () {
        gotourl('services');
      }, 2500);
    }
  });
}

function toastNotification(status, message) {
  if (status === 'Failed') {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2500,
      padding: '0.85rem',
    });

    Toast.fire({
      icon: 'error',
      title: message,
      color: 'white',
    });
  } else if (status === 'Ok') {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2500,
      padding: '0.85rem',
    });

    Toast.fire({
      icon: 'success',
      title: message,
    });
  }
}

function logout() {
  //make api request
  crudaction({}, '/users/logout.php', 'DELETE', function (feed) {
    const { status, message } = feed;

    toastNotification(status, message);

    if (status === 'Ok') {
      setTimeout(function () {
        gotourl('login');
      }, 1500);
    }
  });
}
