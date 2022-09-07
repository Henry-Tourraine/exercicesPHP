<?php
include './utils.php';

function create($table, $values, $pk){
    $temp1 = read();
    $temp = $temp1->$table;
    if($pk != NULL){
    foreach($temp->values as $t){
            if($t->$pk == $values->$pk){

                echo json_encode(["message"=>"$table already exists"]);
                die();
            }
        }
    }
    foreach($values as $k=>$value){
        $values->$k =  htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }
    $id = intval($temp->last_id);
    $new_id = $id+1;
    $values->id = $new_id;
    $temp->values[] = $values;
    $temp->last_id = $new_id;
    $temp1->$table = $temp;
    write($temp1);
    echo json_encode(["message"=>"$table inserted"]);

}

if($_SERVER["REQUEST_METHOD"] =="POST"){
    $params = json_decode(file_get_contents("php://input"));
    if(property_exists($params, "table")  && property_exists($params, "values") && property_exists($params,"pk")){
        create($params->table, $params->values, $params->pk);
    }
}



?>