<?php
 require "db.php";
 $data = $_POST;

 $showError = False;

 if(isset($data['signin'])){
   $errors = array();
   $showError = True;

   if(trim($data['login']) == ''){
     $errors[] = 'Укажите логин.';
   }
   if(trim($data['password']) == ''){
     $errors[] = 'Укажите пароль.';
   }

     $user = R::findOne('users', 'login = ?', array($data['login']));
     if($user){
        if(password_verify($data['password'], $user->password)){
            $_SESSION['users'] = $user;
            header ("Location: ./index.php");

        }else{
            $errors[] = 'Неверный пароль.';
             }
        }else{
            $errors[] = 'Пользователь не найден';
             }
  }


 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/main.css">
	<title>Signin</title>
</head>


<body bgcolor="#292C35">
  <div class="toggle-btn1" onclick="./index.php">
  <a href="./index.php"><span class="span1"></span>
  <span></span>
  <span class="span2"></span></a>
</div>
<div class="wrapper">
  <main class="main">
    <div class="sect" align="center">
      <form action="./signin.php" method="post" class="auth_form">
        <p>Авторизация</p>
        <input id="input" type="text" name="login" placeholder="Логин"><br>
        <input id="input" type="password" name="password" placeholder="Пароль"><br>
            <div class="container">
              <div class="center">
                <button type="submit" name="signin" class="btn">
                  <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
                    <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                    <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                  </svg>
                  <span>Войти</span>
                </button>
              </div>
            </div>
      </form>
<p><?php if($showError) { echo showError($errors); }?></p>


    </div>
</main>

<footer class="footer">
</footer>
</div>




</body>
</html>
