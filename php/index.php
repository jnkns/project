<?php

  require "db.php";
  $user = R::findOne('users', 'id = ?', array($_SESSION['users']->id));
$showError = False;


if(isset($data['index'])){
  $errors = array();
  $showError = True;

    if(trim($data['task']) == ''){
      $errors[] = 'Укажите логин.';
  }
    if(trim($data['deadline']) == ''){
      $errors[] = 'Укажите имя.';
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
  <link rel="stylesheet" href="/css/list.css">
  <link  href="./add.php">
	<title>TO-DO List</title>
</head>


<body bgcolor="#292C35">

<div class="wrapper">

    <?php if($user) : ?>

    <div class="RegAuth">
      <section>
        <div class="link">
          <a id="a" href="logout.php">Выход</a>
        </div>
      </section>
    </div>

<main class="main">
<section class="sect">
  <div class="main-section">
    <div class="add-section">
      <form action="add.php" method="POST" autocomplete="off">
        <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
          <input type="text" name="title" style="border-color: #ff6666" placeholder="This field is required" />
            <button type="submit" name="signup" class="btn">
              <svg viewBox="0 0 1000 60" width="660" height="40px" >
                <polyline points="688,1 688,59 0,59 0,2 688,1" class="bg-line" />
                <polyline points="688,1 688,59 0,59 0,2 688,1" class="hl-line" />
              </svg>
              <span>Добавить +</span>
            </button>

<?php }else{ ?>

  <input type="text" name="title" placeholder="What do you need to do?" />
  <input type="text" name="title" placeholder="Deadline" />
  <button type="submit" name="signup" class="btn">
    <svg viewBox="0 0 1000 60" width="660" height="40px" >
      <polyline points="688,1 688,59 0,59 0,2 688,1" class="bg-line" />
      <polyline points="688,1 688,59 0,59 0,2 688,1" class="hl-line" />
    </svg>
      <span>Добавить +</span>
  </button>

<?php } ?>

  </form>
  </div>

<?php $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC"); ?>

  <div class="show-todo-section">

<?php if($todos->rowCount() <= 0){ ?>

  <div class="todo-item">
    <div class="empty">
      <img src="img/f.jpg" width="100%" />
    </div>
  </div>

<?php } ?>
<?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>

  <div class="todo-item">
    <span id="<?php echo $todo['id']; ?>" class="remove-to-do">x</span>

<?php if($todo['checked']){ ?>

  <input type="checkbox" class="check-box" data-todo-id ="<?php echo $todo['id']; ?>" checked />
    <h2 class="checked"><?php echo $todo['title'] ?></h2>

<?php }else { ?>

  <input type="checkbox" data-todo-id ="<?php echo $todo['id']; ?>" class="check-box" />
    <h2><?php echo $todo['title'] ?></h2>

<?php } ?>

  <br>
    <small>created: <?php echo $todo['date_time'] ?></small>
  </div>

<?php } ?>

  </div>
  </div>

<script src="js/jquery-3.2.1.min.js"></script>

<script>
  $(document).ready(function(){
    $('.remove-to-do').click(function(){
      const id = $(this).attr('id');

        $.post("delete.php",
              {
                  id: id
              },
              (data)  => {
                  if(data){
                     $(this).parent().hide(600);
                  }
              }
        );
    });

    $(".check-box").click(function(e){
      const id = $(this).attr('data-todo-id');

        $.post('check.php',
              {
                              id: id
              },
              (data) => {
                  if(data != 'error'){
                      const h2 = $(this).next();
                      if(data === '1'){
                          h2.removeClass('checked');
                      }else {
                          h2.addClass('checked');
                      }
                  }
              }
        );
    });
});
</script>

  <p><?php if($showError) { echo showError($errors); } ?></p>

      </form>
    </section>
  </main>

    <?php else : ?>

  <div class="RegAuth">
    <section>
      <div class="link">
        <a id="a" href="registration.php">Регистрация</a>
        /
        <a id="a" href="signin.php">Вход</a>
      </div>
    </section>
  </div>
    <main class="main">
      <section class="sect">
      </section>
    </main>

    <?php endif ; ?>

    <div id="sidebar">
      <div class="toggle-btn" onclick="openSidebar()">
        <span></span>
        <span></span>
        <span></span>
      </div>
	     <ul>
         <li>Меню сайта</li>
         <li><a href="index.php">Главная</a></li>
         <li><a href="/">Контакты</a></li>
         <li><a href="/">Репозиторий сайта</a></li>
         <li><a href="/">О нас</a></li>
	     </ul>
    </div>

<footer class="footer">
  ⓒ Dead_Mouse_666
</footer>
</div>


<script>
  function openSidebar() {
    document.getElementById("sidebar").classList.toggle('active');
  }
</script>

</body>
</html>
