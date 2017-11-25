<?php
function articles_all($link){
    //Запрос.
    $query = "SELECT * FROM articles_new ORDER BY id DESC";
    $result = mysqli_query($link, $query);    
    if (!$result)
        die(mysql_error($link));    
    //Извлечение из БД.
    $n = mysqli_num_rows($result);
    $articles = array();
        for ($i = 0; $i < $n; $i++){
        $row = mysqli_fetch_assoc($result);
        $articles[] = $row;
    }
    return $articles;   
}
function articles_get($link, $id_article){
    $query = sprintf("SELECT * FROM articles_new WHERE id=%d", (int)$id_article);
    $result = mysqli_query($link, $query);        
    if (!$result)
        die(mysqli_error($link));        
    $article = mysqli_fetch_assoc($result);        
    return $article;
}
function articles_new($link, $title, $date, $content){
        // Подготовка
        $title = trim($title);
        $content = trim($content);            
        // Проверка
        if ($title == '')
            return false;        
        // Запрос
        $template_add = "INSERT INTO articles_new (title, date, content) VALUES ('%s', '%s', '%s')";        
        $query = sprintf($template_add, 
                         mysqli_real_escape_string($link, $title),
                         mysqli_real_escape_string($link, $date),
                         mysqli_real_escape_string($link, $content));       
        
        $result = mysqli_query($link, $query);        
        if (!$result)
            die(mysqli_error($link));        
        return true;
}
function articles_edit($link, $id, $title, $date, $content){
        // Подготовка
        $title = trim($title);
        $content = trim($content);
        $date = trim($date);
        $id = (int)$id;            
        // Проверка
        if ($title == '')
            return false;        
        // Запрос
        $sql = "UPDATE articles_new SET title='%s', content='%s', date='%s' WHERE id='%d'";            
        $query = sprintf($sql, 
                         mysqli_real_escape_string($link, $title),
                         mysqli_real_escape_string($link, $content),
                         mysqli_real_escape_string($link, $date),
                         $id);        
        $result = mysqli_query($link, $query);        
        if (!result)
            die(mysqli_error($link));        
        return mysqli_affected_rows($link);
    }
function articles_delete($link, $id){
        $id = (int)$id;
        // Проверка
        if ($id == 0)
            return false;        
        // Запрос
        $query = sprintf("DELETE FROM articles_new WHERE id='%d'", $id);
        $result = mysqli_query($link, $query);        
        if (!result)
            die(mysqli_error($link));        
        return mysqli_affected_rows($link);
    }
function articles_intro($text, $len = 500)
    {
        return mb_substr($text, 0, $len);        
    }
?>