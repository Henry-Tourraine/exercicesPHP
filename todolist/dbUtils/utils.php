<?php
function read(){
    $content = file_get_contents('C:/xampp/htdocs/AlexandreExercice/exerciceNextLevel/todoList/db.json');
    return json_decode($content);
}


function write($text){
    $content = file_put_contents('C:/xampp/htdocs/AlexandreExercice/exerciceNextLevel/todoList/db.json', json_encode($text));
 
}
?>