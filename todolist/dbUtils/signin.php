<?php


include './utils.php';

function signin($table, $name, $pwd){

        $temp = read()->$table;
        foreach($temp->values as $t){
            if($t->name == $name && $t->pwd == $pwd){
                setcookie("auth", json_encode($t), time() + (86400 * 30), "/");
                setcookie("infos", json_encode($t), time() + (86400 * 30), "/");
                return json_encode(["message"=>true]);
            }
        }
        return json_encode(["message"=>false]);
}


if($_SERVER["REQUEST_METHOD"] =="POST"){
    $params = json_decode(file_get_contents("php://input"));
    if(property_exists($params, "table")  && property_exists($params, "name") && property_exists($params, "pwd")){
        echo signin($params->table, $params->name, $params->pwd);
    }
}

?>
