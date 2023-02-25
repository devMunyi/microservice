<?php
include_once("../php_functions/functions.php");
include_once("../configs/conn.inc");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Microservices | CreateAccount</title>
    <!-- Tell the browser to be responsive to screen width -->
    <?php
    include_once("includes/header-includes.php")
    ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- <div class="login-logo">
        <img src="dist/img/braavos.png"  alt="BRAAVOS" style="font-weight: bold; height: 120px;">
    </div> -->
    <!-- /.login-logo -->
    <div class="login-box-body bs">
        <div class="text-center title bg-info px-4 py-3">Create Account</div>
        <form class="p-4" onsubmit="return false;" method="post">
            <div class="mb-3">
                <!-- <label for="email" class="form-label">Email address</label> -->
                <input type="email" class="form-control" id="inp_email" placeholder="Email" required>
            </div>

            <div class="mb-3">
                <!-- <label for="email" class="form-label">Email address</label> -->
                <input type="text" class="form-control" id="inp_name" placeholder="Firstname Lastname" required>
            </div>

            <div class="mb-3">
                <select class="form-control" id="inp_company" required>
                    <option value="0">--Company</option>
                    <?php
                    $recs = fetchtable('tbl_companies', "status > 0", "id", "asc", "10", "id ,name");
                    while ($r = mysqli_fetch_array($recs)) {
                        $id = $r['id'];
                        $name = $r['name'];
                        echo "<option value=\"$id\">$name</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <!-- <label for="password" class="form-label">Password</label> -->
                <input type="password" class="form-control" id="inp_password" placeholder="Password" required>
            </div>

            <div class="mb-3">
                <!-- <label for="password" class="form-label">Password</label> -->
                <input type="password" class="form-control" id="inp_confirm_password" placeholder="Password Confirmation" required>
            </div>

            <!-- <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->

            <div class="d-grid submitbtn">
                <button type="submit" onclick="createAccount()" class="btn btn-outline-info w-100">Submit</button>
            </div> 
            
            <p class="mt-4 mb-0 text-center">Have an account?<a class="text-decoration-underline" href="login"> Login</a></p>
        </form>

        <!-- /.social-auth-links -->


    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php
  include_once("includes/footer-includes.php");
?>
<script>
    submitBtn('createAccount()', class="btn btn-outline-info w-100");
</script>
</body>
</html>
