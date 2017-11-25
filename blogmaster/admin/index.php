<?php
    require_once("../database.php"); // подключаем файл, который взаимодействует с базой
    require_once("../models/articles.php"); // подключаем файл, который отвечает за работу со статьями

    $link = db_connect(); // созраняем результат соединения с базой в переменную link

    $article['title']='';
    $article['date']='';
    $article['content']='';

    if(isset($_GET['action']))
        $action = $_GET['action'];
    else
        $action = "";
    
    if($action == "add"){
        if(!empty($_POST)){
            articles_new($link, $_POST['title'], $_POST['date'], $_POST['content']);
            header("Location: index.php");
        }
        include("../views/article_admin.php");
    }else if($action == 'edit'){
        if(!isset($_GET['id']))
            header('Location: index.php');
        $id = (int)$_GET['id'];
        
        if(!empty($_POST) && $id > 0) {
            articles_edit($link, $id, $_POST['title'], $_POST['date'], $_POST['content']);
            header("Location: index.php");
        }
        
        $article = articles_get($link, $id);
        include("../views/article_admin.php"); 
    }
    else if($action == 'delete'){
        $id = $_GET['id'];
        $article = articles_delete($link, $id);
        header('Location: index.php');
    }

    else{
        $articles = articles_all($link);
        include("../views/articles_admin.php");        
    }
?>