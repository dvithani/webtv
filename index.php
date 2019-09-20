<?php

include 'includes/header.php';
if (isset($_SESSION['webTvplayer']) && !empty($_SESSION['webTvplayer'])) {
  ?>
  <script>
    window.location.href = 'dashboard.php';
  </script>
<?php
  exit();
}

$cookieusername = (isset($_COOKIE['username']) ? $_COOKIE['username'] : '');
$FinalUsername = (isset($_GET['username']) ? $_GET['username'] : $cookieusername);
$cookiepassword = (isset($_COOKIE['userpassword']) ? base64_decode($_COOKIE['userpassword'], true) : '');
$FinalPassword = (isset($_GET['password']) ? $_GET['password'] : $cookiepassword);
?>
<style type="text/css">
  .addborder {
    border: 1px solid red !important;
  }

  .hideOnload {
    display: none !important;
  }

  div#FailLOginMessage {
    position: fixed;
    top: -100%;
    text-align: center;
    left: 35%;
    width: 30%;
  }
</style>
<!-- <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container full-container navb-fixid">
      <div class="navbar-header">
        
      </div>
      <a class="" href="#"><img class="img-responsive" src="img/logo.png" alt="" width="187px"></a>
      
     //.nav-collapse
    </div>
  </nav> -->
<div class="alert alert-danger " id="FailLOginMessage">
  <strong>Error!</strong> <span id="ErrorText">Invalid Details</span>
</div>
<div class="container-fluid">
  <!-- Login Wrapper -->
  <center><a href="dashboard.php"><img class="img-responsive" src="<?php echo isset($XClogoLinkval) && !empty($XClogoLinkval) ? $XClogoLinkval : 'img/logo.png'; ?>" alt="" onerror="this.src='img/logo.png';" width="200px" style="margin-top: 40px;"></a>
  </center>
  <div class="midbox">
    <h3>Login With Your Account</h3>
    <form>
      <div class="form-group">
        <label>Username</label>
        <input type="username" class="form-control logininputs" id="input-login" placeholder="Username" value="<?php echo $FinalUsername; ?>">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control logininputs" id="input-pass" placeholder="Password" value="<?php echo $FinalPassword; ?>">
        <div class="checkbox checkbox_new">
          <label>
            <input type="checkbox" id="rememberMe"> Remember me
          </label>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-ghost webtvloginprocess rippler rippler-default">LOGIN <i class="fa fa-spin fa-spinner hideOnload" id="loginProcessIcon"></i></button>
      </div>
    </form>
  </div>
  <!-- /Login Wrapper -->
</div>
<?php
include 'includes/footer.php';
?>