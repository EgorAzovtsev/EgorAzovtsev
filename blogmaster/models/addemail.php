<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Мой блог</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <h1>Мой блог</h1>
  <p>Введите свои данные, чтобы подписаться на обновления!</p>

<?php
  if (isset($_POST['submit'])) {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $output_form = 'no';

    if (empty($first_name) || empty($last_name) || empty($email)) {
  
      echo 'Пожалуйста, заполните все поля.<br>';
      $output_form = 'yes';
    }
  }
  else {
    $output_form = 'yes';
  }

  if (!empty($first_name) && !empty($last_name) && !empty($email)) {
    $dbc = mysqli_connect('localhost', 'root', '', 'blog')
      or die('Ошибка подключения к серверу.');

    $query = "INSERT INTO email_list (first_name, last_name, email)  VALUES ('$first_name', '$last_name', '$email')";
    mysqli_query($dbc, $query)
      or die ('Данные не добавлены.');

    echo 'Добавлен новый подписчик!';

    mysqli_close($dbc);
  }

  if ($output_form == 'yes') {
?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="firstname">Имя:</label>
    <input type="text" id="firstname" name="firstname"><br>
    <label for="lastname">Фамилия:</label>
    <input type="text" id="lastname" name="lastname"><br>
    <label for="email">Email:</label>
    <input type="text" id="email" name="email"><br>
    <input type="submit" name="submit" value="Подписаться">
  </form>

<?php
  }
?>




<br>
<p><a href="../index.php">Вернуть на главную.</a></p>  
</div>
</body>
</html>
