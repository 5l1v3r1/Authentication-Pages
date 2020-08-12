<?php
error_reporting(0);
include 'db_connect.php';
$username=$email=$password=$passwordd=$numberr='';
$error = array('username' => '','email' => '','password' => '','passwordd' => '','numberr' => '');
$au = array('auser' => '');
if(isset($_POST['submit']))
 {
  $username=mysqli_escape_string($conn,$_POST['username']);
  $email=mysqli_escape_string($conn,$_POST['email']);
  $password=mysqli_escape_string($conn,$_POST['password']);
  $passwordd=mysqli_escape_string($conn,$_POST['passwordd']);
  $numberr=mysqli_escape_string($conn,$_POST['numberr']);
  
    //check username

    if(empty($username))
    {
    $error['username'] = "Username Required";
    }
    else
    {
      if(!preg_match('/^[a-zA-Z\s]+$/', $username))    
        $error['username'] = "Invalid username<br>";
    }

    //check email

    if(empty($email))
    {
      $error['email'] = "Email is required";
    }
    else
    {
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
       $error['email'] = "Please enter a valid email";
    }
    }


    //check password

    if(empty($password))
    {
    $error['password'] = "Password is required<br>";
    }
    else
    {
    if(strlen($password) < 8 || strlen($password)  > 16)
    $error['password'] = "Password length should be between 8 to 16 characters";

    }
    if(empty($passwordd))
    {
     $error['passwordd'] = "You need to re-enter your Password.<br>";
    }
    else
    {
    if(!$password == $passwordd)
    $error['passwordd'] = "Please re enter your password";
    } 

    //check number

    if(!is_numeric($numberr)) 
    {
      $error['numberr'] = "Please enter a valid number";
    }

    if(!array_filter($error))
    {
      $sql="SELECT * FROM Users WHERE Username = '$username' AND Email= '$email'  AND Numberr=$numberr ";
     $res=mysqli_query($conn,$sql);
     if(!mysqli_num_rows($res))
     {
       $password = md5($password);
       $sqlt="INSERT INTO Users(Username,Email,Password,Numberr) VALUES('$username','$email','$password',$numberr)";
       $rest=mysqli_query($conn,$sqlt);
       mysqli_close($conn);
       header("Location:Login.php");
     }
     else
     {
     
      $au['auser'] =  "Email already registered kindly login";
     
     }

  
}}
 ?>













 <!DOCTYPE html>
 <html>
 <head>
   <title>Sign-up</title>
   <style type="text/css">
     body, html {
  height: 50%;
}

* {
  box-sizing: border-box;
}

.bg-img {
  /* The image used */
  background-image: url("https://wallpaperaccess.com/full/337490.jpg");
 
  /* Control the height of the image */
  min-height: 380px;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

/* Add styles to the form container */
.container {
  position: center;
  right:0;
  margin: 0px;
  max-width: 300px;
  padding: 20px;
  background-image: url(https://us.123rf.com/450wm/lumitar/lumitar1601/lumitar160100015/50129477-seamless-pattern-with-sea-green-spiral-waves-on-a-off-white-background-pastel-color-palette.jpg?ver=6);

}


/* Full-width input fields */
  input[type=text], input[type=password] {
  width: 100%;
  padding: 10px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;

}
 input[type=text], input[type=email] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=email]:focus {
  background-color: #ddd;
  outline: none;

}
 input[type=text], input[type=username] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=username]:focus {
  background-color: #ddd;
  outline: none;

}
 input[type=text], input[type=passwordd] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=passwordd]:focus {
  background-color: #ddd;
  outline: none;

}
 input[type=text], input[type=numberr] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=numberr]:focus {
  background-color: #ddd;
  outline: none;

}
/* Set a style for the submit button */
/*.btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}*/

.btn:hover {
  opacity: 1;
  background-image:none;
  background-color:#ff00ff;
}
   </style>
<script type="text/javascript">
  

const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('passwordd');

form.addEventListener('submit', e => {
  e.preventDefault();
  
  checkInputs();
});

function checkInputs() {
  // trim to remove the whitespaces
  const usernameValue = username.value.trim();
  const emailValue = email.value.trim();
  const passwordValue = password.value.trim();
  const passworddValue = passwordd.value.trim();
  
  if(usernameValue === '') {
    setErrorFor(username, 'Username cannot be blank');
  } else {
    setSuccessFor(username);
  }
  
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
  
  if(passworddValue === '') {
    setErrorFor(passwordd, 'Password2 cannot be blank');
  } else if(passwordValue !== passworddValue) {
    setErrorFor(passwordd, 'Passwords does not match');
  } else{
    setSuccessFor(passwordd);
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
 <div class="bg-img">
 <body style="background-color: white">
<form action="#" method="POST" style="color:black" class="container" id="form" class="form">
  <h1><strong>Register</strong></h1>
  <div style="color: red"><?php echo $au['auser']?></div>
  <hr>
  <div class="form-control">
   <h1>Username</h1>
     <input type="username" name="username"  value="<?php echo htmlspecialchars($username) ?>" id="username"> 
     <div style="color: red"><?php echo $error['username']?></div>
     <h1>Email</h1>
     <input type="email" name="email"  value="<?php echo htmlspecialchars($email) ?>" id
     ="email">
     <div style="color: red"><?php echo $error['email']?></div>
     </div>
     <div class="form-control">
     <h1>Password</h1>
     <input type="password" name="password"  value="<?php echo htmlspecialchars($password) ?>" id="password">
     <div style="color: red"><?php echo $error['password']?></div>
     </div>
     <div class="form-control">
     <h1>Re-enter Password</h1>
     <input type="password" name="passwordd"  value="<?php echo htmlspecialchars($passwordd) ?>" id="passwordd">
     <div style="color: red"><?php echo $error['passwordd']?></div>
     </div>
     <div class="form-control">
     <h1>Contact Number</h1>
     <input type="text" name="numberr"  value="<?php echo htmlspecialchars($numberr) ?>">
     <div style="color: red"><?php echo $error['numberr']?></div>
     <br>
     <input class=".btn" type="submit" value="SUBMIT" name="submit"></input>
     <hr>
     </div>
     <a href="Login.php"><pre>LOGIN</pre></a>
     <a href="about_us.php"><pre>About us</pre></a>
 
</form>
 </body>
</div>
 </html>