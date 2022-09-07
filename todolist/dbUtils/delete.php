<?php
include './utils.php';

function delete($table, $where){
    $flag =false;
    $count = 0;
    $where = (array)$where;
    $key = array_keys($where)[0];
    $temp1 = read();
    $temp = $temp1->$table->values;
    for($i=0; $i<count($temp); $i++){
        if($temp[$i]->$key == $where[$key]){
            array_splice($temp, $i, 1);
            $flag = true;
            $count++;
        }
    }
    $temp1->$table->values = $temp;
    write($temp1);
    if($flag == false){
        echo json_encode(["message"=>"Element doesn't exist !"]);
    }else{
        echo json_encode(["message"=>"$count element(s) deleted"]);
    }
}
if($_SERVER["REQUEST_METHOD"] =="POST"){
    $params = json_decode(file_get_contents("php://input"));
    if(property_exists($params, "table")  && property_exists($params, "where")){
        echo delete($params->table, $params->where);
    }
}
//delete("Users",array("id"=>1));
?>