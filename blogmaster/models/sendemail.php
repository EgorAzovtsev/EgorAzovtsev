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
 
  <p>Пора отправить оповещения подписчикам! Не забудь указать тему и тело письма :)</p>

<?php
  if (isset($_POST['submit'])) {
    $from = 'azvegr@rambler.ru';
    $subject = $_POST['subject'];
    $text = $_POST['elvismail'];
    $output_form = false;

    if (empty($subject) && empty($text)) {
   
      echo 'Ты забыл указать тему и тело письма.<br>';
      $output_form = true;
    }

    if (empty($subject) && (!empty($text))) {
      echo 'Ты забыл указать тему письма.<br>';
      $output_form = true;
    }

    if ((!empty($subject)) && empty($text)) {
      echo 'Ты забыл заполнить тело письма.<br>';
      $output_form = true;
    }
  }
  else {
    $output_form = true;
  }

  if ((!empty($subject)) && (!empty($text))) {
    $dbc = mysqli_connect('localhost', 'root', '', 'blog')
      or die('Ошибка подключения к серверу.');

    $query = "SELECT * FROM email_list";
    $result = mysqli_query($dbc, $query)
      or die('Ошибка запроса к базе данных.');

    while ($row = mysqli_fetch_array($result)){
      $to = $row['email'];
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $msg = "Дорогой $first_name $last_name,\n$text";
      mail($to, $subject, $msg, 'От:' . $from);
      echo 'Email отправлено для: ' . $to . '<br>';
    } 

    mysqli_close($dbc);
  }

  if ($output_form) {
?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="subject">Тема письма:</label><br>
    <input id="subject" name="subject" type="text" value="<?php echo $subject; ?>" size="30"><br>
    <label for="elvismail">Тело письма:</label><br>
    <textarea id="elvismail" name="elvismail" rows="8" cols="40"><?php echo $text; ?></textarea><br>
    <input type="submit" name="submit" value="Submit">
  </form>

<?php
  }
?>
<br>
<p><a href="../admin/index.php">Вернуться в панель администратора</a></p>
</div>
</body>
</html>
