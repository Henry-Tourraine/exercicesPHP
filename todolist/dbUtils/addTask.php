<?php


include './utils.php';


function addTask($name, $user_id, $check){
        $table = "Lists";
        $temp1 = read();
        $temp = $temp1->$table;
        $id = $temp->lastId;
       
        $values = $temp->values;
        
        $values[] = ["name"=>htmlspecialchars($name), "value"=>htmlspecialchars($check),"user_id"=>$user_id, "id"=>$id];
       
        $temp->values = $values;
        $temp->lastId = $id+1;
        $temp1->$table = $temp;
        write($temp1);
        return json_encode(["message"=>true]);
        
        
       
}


if($_SERVER["REQUEST_METHOD"] =="POST"){
    
    $params = json_decode(file_get_contents("php://input"));
    if(property_exists($params, "name") && property_exists($params, "user_id") && property_exists($params, "check")){
        echo addTask($params->name, $params->user_id, $params->check);
    }
}

?>
