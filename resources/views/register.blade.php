<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Web Portal - Register</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <!-- <form class="user"> -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="firstname" placeholder="First Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="lastname" placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-contol-user" id="email" placeholder="test@gmail.com">
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="number" class="form-control form-contol-user" id="mobilenumber" placeholder="Mobile Number">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" id="username" placeholder="Username">
                    </div>
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password1" placeholder="Password">
                  </div>
                  <div class="col-sm-4">
                    <input type="password" class="form-control form-control-user" id="password2" placeholder="Repeat Password">
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-user btn-block" id="register">Register Account</button>
                <!-- <a href="login.html" class="btn btn-primary btn-user btn-block">
                  Register Account
                </a> -->
              <!-- </form> -->
              <hr>
              <div class="text-center">
                <a class="small" href="{{ url('/') }}">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- The Modal -->
<div class="modal fade" id="modalVerification">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Verify Account</h4>
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-md-12">
            <label><i>Verification code has been sent to your email.</i></label>
            <div class="row">
                <div class="col-md-6">
                    <label for="verification_code">Verification Code</label>
                    <input type="text" class="form-control" id="verification_input"/>
                </div>
                <div class="col-md-6">
                    <label for="verifybutton">Verify</label>
                    <button type="button" id="verify" class="form-control btn btn-primary">Verify</button>
                </div>
            </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
      </div>

    </div>
  </div>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <script>
    $(document).ready(function(){

        var userId;
        var verificationCode;

        $(document).on('click', '#register', function(){
            userRegister();
        });

        $(document).on('click', '#verify', function(){
            verifyAccount();
        });

        function userRegister(){

            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();
            var mobilenumber = $('#mobilenumber').val();
            var password1 = $('#password1').val();
            var password2 = $('#password2').val();
            var username = $('#username').val();
            var newnumber;

            if(mobilenumber.indexOf('0') !== -1){
                newnumber = mobilenumber.replace("0", "+63");
            }

            if((firstname != "") || (lastname != "") || (email != "") || (mobilenumber != "") || (password1 != "") || (password2 != "")){
                if(password1 != password2){
                    toastr.error("Password did not match");
                }else{
                    var fullname = firstname + " " + lastname;
                    var d = new Date();
                    var date = d.getDate();
                    var month = d.getMonth();
                    var day = d.getDay();
                    verificationCode = date + month + day;
                    $.ajax({
                        url: "{{ url('api/registerAccount') }}",
                        method: "POST",
                        dataType: "JSON",
                        data : {
                            fullname: fullname,
                            email : email,
                            mobilenumber: newnumber,
                            password: password1,
                            username: username,
                            verificationcode : verificationCode
                        }
                    }).done(function(response){
                        if(!response.success){
                            toastr.error(response.message);
                        }else{
                            toastr.success(response.message);
                            userId = response.data;
                            $('#modalVerification').modal({backdrop: 'static', keyboard: false});
                        }
                    });
                }
            }else{
                toastr.error("Please fill out the form correctly!");
            }
        }

        function verifyAccount(){
            var verification_input = $('#verification_input').val();
            $.ajax({
                url : "{{ url('api/verifyUser') }}",
                method : "POST",
                dataType: "JSON",
                data : {
                    verification_input : verification_input,
                    userId : userId
                }
            }).done(function(response){
                if(response.success){
                    toastr.success(response.message);
                    $('#modalVerification').modal("hide");
                }else{
                    toastr.error(response.message);
                }
            });
        }

    });
  </script>

</body>

</html>
