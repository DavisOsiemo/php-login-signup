<?php
//include 'application.php';
require 'kuhappendb.php';
ob_start();
session_start();

function loggedIn(){
    if (isset($_SESSION['user_id'])&& !empty($_SESSION['user_id'])){
      return true;
  }else {
    return false;
  }
  
}
function getField($field){
        $user_id = $_SESSION['user_id'];
       $query = "SELECT `$field` FROM `users` WHERE `user_id`='".$user_id."'";
       if ($query_run = mysql_query($query)){
        if ($query_result= mysql_result($query_run, 0, $field)){
          return $query_result;
        }
       }
    }
if (loggedIn()){
  $firstname = getField('fname');
  $sname = getField('sname');
  echo "You are logged in as $firstname $sname <br>";
  echo '<a href="logout.php"> Click here to Log out</a>';
}else {

if (isset($_POST['email']) && isset($_POST['password'])){
      $email = $_POST['email'];
      $password = $_POST['password'];
      $password_hash = $password;

      if (!empty($email) && !empty($password)){
      //$query = "SELECT `user_id` FROM `users` WHERE `email`='".mysql_real_escape_string($email)."' AND `password`='".mysql_real_escape_string($password_hash)."'";
        //The above syntax is obsolete for php 7
      $query = "SELECT user_id FROM users WHERE email=:email AND password=:password";
      $stmt=$connection->prepare($query);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $password);
      $stmt->execute();
      //$query_run = mysql_query($query);
     /* if ($stmt->rowCount()>=0){
        echo "<span style='color: #ff5050'/> <p> Invalid pass/email combination </p> </span>";
      }else {
        echo "Logged in";
      }*/
      if ($query_run = $stmt->execute()){
        //$query_num_rows = mysql_num_rows($query_run);
        if ($stmt->rowCount()==0) {
          echo "<span style='color: red'/> <p>Invalid email/password combination </p> </span>";
        } else {
          die('Logged in');
          $user_id = mysqli_query($query_run, 0, 'user_id');
          $_SESSION['user_id']= $user_id;
          header('Location: login.php');
        }
      }
    } else {
      echo "<span style='color: #ff5050'/><p>Fill in both fields</p> </span>";
    }
  }
}



  /*$records= $connection->prepare($query);
  $records->bindParam(':email',$_POST['email']);
  $records->execute();

  $results = $records->fetch(PDO::FETCH_ASSOC);
  $real = $results['password'];
  $real_password = crypt($real);
  $user_password = $_POST['password'];

  if (count($results) > 0/*&& crypt($user_password) == $real_password){
    echo $_POST['password']. "<br>";
    echo $records->bindParam(':email',$_POST['email']);
    die ('We have a login');
  } else {
    die ('Error logging in');
  }*/

?>

<html>
  <head> <title> Log in below</title> 
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
  <script type="text/javascript">
      function displayMessage(){
        alert("You are logged in");
      }
      function checkField(){
        alert("This field is required");
      }
      function upperCase(){
        var x = document.getElementById("fname").value;
        document.getElementById("fname").value = x.toUpperCase();
      }
  </script>
  </head>
  
  <body>

  	<div class= "header">
  		<a href= "auth.php"> Kuhappen </a>
  	</div>

  	<h1> Log in</h1>
  	<span> or <a href="signup.php"> Register here </a> </span>

  	<form action = "login.php" method= "POST">
      <input type="text" id="fname" onblur="upperCase()">
  		<input type= "text" placeholder= "Enter your email" name="email">
  		<input type= "password" placeholder= "and password" name= "password"> 
  		<input type= "submit" value= "Log in">
  	</form>
  </body>
</html>