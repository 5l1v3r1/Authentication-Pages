<?php
include 'db_connect.php';
$email=$password='';
$error = array("email" => '',"password" => '');
$logerr= array('result' => '');
if(isset($_POST['submit']))
{
 $email=mysqli_escape_string($conn,$_POST['email']);
 $password=mysqli_escape_string($conn,$_POST['password']);
 if(empty($email))
  {
  $error['email']= "Please enter your email";
  }
 else
  {
  if(!filter_var($email,FILTER_VALIDATE_EMAIL))
  {
    $error['email'] = "Please enter a valid email";
  }

 }
 if(empty($password))
 {
  $error['password']= "Please enter your password";
 }
 else
 {
  if(strlen($password) < 8 || strlen($password)  > 16)
  $error['password'] = "Password lengeth should be between 8 to 16 characters";
 }
 if(!array_filter($error))
 {
  $password=md5($password);
  $que = "SELECT * FROM Users WHERE Email = '$email' AND Password = '$password' ";
  $result = mysqli_query($conn,$que);
  if(!mysqli_num_rows($result))    //checks the number of rows returned if rows returned it says true o/w false. //here it means what to do when , 0 number of rows are returned.
  {
    $logerr['result'] = " Incorrect Email or Password ";
  }
  else
  {
      session_start();
      foreach ($result as $res )
     {
      $_SESSION['name'] = $res['Username'];
      $_SESSION['email'] = $res['Email'];
      $_SESSION['password'] = $res['Password'];
      $_SESSION['numberr'] = $res['Numberr'];

     }
     include 'Login_log.php';
     header("Location:about_uss.php");
      
  }
 }
}
















?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style type="text/css">
body {
  background: #999;
  padding: 40px;
  margin-top: 210px;
}

#bg {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: url(https://wallpapercave.com/wp/U9z2L0M.jpg) no-repeat center center fixed;
  background-size: cover;  
}

form {
  position: relative;
  width: 250px;
  margin: 0 auto;
  background: rgba(130,130,130,.3);
  padding: 20px 22px;
  border: 3px solid;

}

form input, form button {
  width: 212px;
  border:0px solid;
  background-color: rgba(0,0,0,.2);
  background-repeat: no-repeat;
  padding: 8px 24px 8px 10px;
  letter-spacing: .075em;
  color: #fff;
  text-shadow: 0 1px 0 rgba(0,0,0,.1);
  margin-bottom: 19px;
}

form input:focus { background-color: rgba(0,0,0,.4); }

form input.email {
  background-color: black;
  background-position: 220px 10px;
}

form input.pass {
  background-color: black;
  background-position: 223px 8px
}

::-webkit-input-placeholder { color: #ccc; text-transform: uppercase; }
::-moz-placeholder { color: #ccc; text-transform: uppercase; }
:-ms-input-placeholder { color: #ccc; text-transform: uppercase; }

form button[type=submit] {
  width: 248px;
  margin-bottom: 0;
  color: #3f898a;
  letter-spacing: .05em;
  text-shadow: 0 1px 0 #133d3e;
  text-transform: uppercase;
  background: #225556;
  cursor: pointer;
}
.form-control.success i.fa-check-circle {
  color: #2ecc71;
  visibility: visible;
}

.form-control.error i.fa-exclamation-circle {
  color: #e74c3c;
  visibility: visible;
}
</style>
 </style>
<script type="text/javascript">
  

const form = document.getElementById('form');
const email = document.getElementById('email');
const password = document.getElementById('password');
form.addEventListener('submit', e => {
  e.preventDefault();
  
  checkInputs();
});

function checkInputs() {
  // trim to remove the whitespaces
  const emailValue = email.value.trim();
  const passwordValue = password.value.trim();
  
  if(emailValue === '') {
    setErrorFor(email, 'Email cannot be blank');
  } else if (!isEmail(emailValue)) {
    setErrorFor(email, 'Not a valid email');
  } else {
    setSuccessFor(email);
  }
  
  if(passwordValue === '') {
    setErrorFor(password, 'Password cannot be blank');
  } else {
    setSuccessFor(password);
  }
  
}

function setErrorFor(input, message) {
  const formControl = input.parentElement;
  const small = formControl.querySelector('small');
  formControl.className = 'form-control error';
  small.innerText = message;
}

function setSuccessFor(input) {
  const formControl = input.parentElement;
  formControl.className = 'form-control success';
}
  
function isEmail(email) {
  return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}
// SOCIAL PANEL JS
const floating_btn = document.querySelector('.floating-btn');
const close_btn = document.querySelector('.close-btn');
const social_panel_container = document.querySelector('.social-panel-container');

floating_btn.addEventListener('click', () => {
  social_panel_container.classList.toggle('visible')
});

close_btn.addEventListener('click', () => {
  social_panel_container.classList.remove('visible')
});
</script>







</head>
<body>
  <div id="bg"></div>

<form action="#" method="POST" id="form" class="form">
   <div class="form-control">
  <input type="email" name="email"  placeholder="email" class="email" value="<?php echo $email?>" id="email">
  <i class="fas fa-check-circle"></i>
      <i class="fas fa-exclamation-circle"></i>
  <div style="color: red; background-color: black"><?php echo htmlspecialchars($error['email'])?></div>
</div>
  <br>
   <div class="form-control">
  <input type="password" name="password" placeholder="password" class="pass" value="<?php echo $password?>" id="password">
  <div style="color: red; background-color: black;"><?php echo htmlspecialchars($error['password'])?></div>
  <br>
  <div style="color: red; background-color: black"><?php echo htmlspecialchars($logerr['result'])?></div>
  <br>
   </div>
  <button type="submit" name="submit" value="submit">Submit</button>
  <a href="Sign_in.php" style="color: black"><pre><strong>Register</strong></pre></a>
    
</form>


</body>
</html>