<?php
require 'kuhappendb.php';
if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
  $referer = $_SERVER['HTTP_REFERER'];
}
$message ='';
if (isset($_POST['fname']) && isset($_POST['sname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['phone_number'])){
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $fname = $_POST['fname'];
  $sname = $_POST['sname'];
  $email = $_POST['email'];
  $phone_number = $_POST['phone_number'];
  if (!empty($_POST['fname']) && !empty($_POST['sname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['phone_number'])){
    if ($password!=$confirm_password){
        echo "<span style='color: #ff5050;'/> <p> Passwords should match </p> </span>";
        }elseif (strlen($password)<6 ) {
          echo "<span style='color: #ff5050;'/> <p> Password should be a minimum of 6 characters long </p> </span>";
        }elseif (!preg_match('/^[a-z0-9A-Z]*$/', $password)) {
          echo "Password must be alphanumeric";
        } else {

        if (!ctype_digit($phone_number) || strlen($phone_number)!=10){
          echo "<span style='color: #ff5050'/> <p>Your phone number should be numeric and 10 characters long </p> </span>";
        } else {
            $query = "SELECT email FROM users WHERE email=:email";
            $my_stmt = $connection->prepare($query);
            $my_stmt->bindParam(':email',$_POST['email']);
            $my_stmt->execute();
            if ($my_stmt->rowCount()>=1){
              echo "<span style='color: #ff5050;'/> <p> Email already exists. You may <a href='#''> Login </a> here</p> </span> ";
            }else {
              $sql = "INSERT INTO users (fname, sname, email, password, confirm_password,phone_number) VALUES (:fname, :sname,:email, :password, :confirm_password, :phone_number)";
              $stmt = $connection->prepare($sql);
            	$stmt->bindParam(':fname', $_POST['fname']);
            	$stmt->bindParam(':sname', $_POST['sname']);
            	$stmt->bindParam(':email', $_POST['email']);
            	$stmt->bindParam(':password', @md5($password));
            	$stmt->bindParam(':confirm_password', $_POST['confirm_password']);
            	$stmt->bindParam(':phone_number', $_POST['phone_number']);
              if ($stmt->execute() ){
                  echo "<span style='color: #ff5050;'/> <p> Successfully created new account </p> </span>";
              } else {
                echo "<span style='color: #ff5050;'/> <p> Account not created </p> </span>";
        }
      }
    }
  }
  } else {
    echo "<span style='color: #ff5050;'/> <p> All fields are required </p> </span>";
  }
}
/*echo ' 
<!DOCTYPE html>
<html>
<img src="1.jpg" width="280" height="125" title="Logo of a company" alt="Logo of a company" />

</html>
'*/
?>
<html>
  <head> <title> Register below</title> 
    <style>
     body {
        background: url('1.jpg') no-repeat center fixed;
        margin: 0px;
        padding: 0px;
        font-family: 'Comfortaa', cursive;
        text-align: center;
      }
      input[type= "text"], input[type="password"]{
        outline: none;
        padding:10px;
        display: block;
        width: 300px;
        border-radius: 3px;
        border: 1px solid #eee;
        margin: 20px auto;
      }
      input[type="submit"]{
        padding: 10px;
        width: 320px;
        color:#fff;
        background: #0098cb;
        margin: 20px auto;
        margin-top: 0px;
        cursor: pointer;
        border-radius: 3px;
        border:0;
      }
      input[type="submit"]:hover{
        background:#00b8eb;
      }
      .header {
        padding: 10px 0px;
        width: 100%;
        text-align: center;
        border-bottom: 1px solid #eee;
      }
      .header a{
        color: #333;
        text-decoration: none;
      }
      h1 {
        color: rgb(255, 102, 0) ;
      }
    </style>
  </head>
  <body>
    <img src="<? //php echo "1.jpg"; ?>"
  	<div class= "header">
      <?php if (!empty($message)){ ?>
        <p> <?=$message?> </p>
      <?php } ?>
      
  		<a href= "auth.php"> Kuhappen </a>
    	</div>
    	<h1> Sign up or <a href="login.php"> Login here </a> </h1>

    	<form action = "signup.php" method= "POST">

  		<input type= "text" placeholder= "First name" name="fname" value="<?php if (isset($fname)){echo $fname;}?>">
  		<input type= "text" placeholder= "Second name" name= "sname" value="<?php if (isset($sname)){echo $sname;}?>"> 
  		<input type= "text" placeholder= "Email" name= "email" value="<?php if (isset($email)){echo $email;}?>"> 
  		<input type= "password" placeholder= "Password" name= "password"> 
  		<input type= "password" placeholder= "Confirm password" name= "confirm_password"> 
  		<input type= "text" placeholder= "Phone number" name= "phone_number" value="<?php if (isset($phone_number)){echo $phone_number;}?>"> 
  		<input type= "submit" value= "Register">
  	</form>
  </body>
</html>