<?php

include './utils.php';

function find($table, $where=NULL){

    if($where == NULL){
        return json_encode(["data"=> read()->$table]);
    }else{
        $where = (array)$where;
        $key = array_keys($where)[0];
        $temp = read()->$table;
        foreach($temp->values as $t){
            if($t->$key == $where[$key]){
                return json_encode(["data"=> $t]);
            }
        }
    }
    return json_encode(["data"=> []]);
}


if($_SERVER["REQUEST_METHOD"] =="POST"){
    $params = json_decode(file_get_contents("php://input"));
    if(property_exists($params, "table")  && property_exists($params, "where")){
        echo find($params->table, $params->where);
    }
}

?>