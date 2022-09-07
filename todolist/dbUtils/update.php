
<?php
include './utils.php';

function update($table, $where, $values){
    $flag =false;
    $count = 0;
    $where = (array)$where;
    $values = (array)$values;
    $key = array_keys($where)[0];
    $temp1 = read();
    $temp = $temp1->$table->values;
    foreach($temp as $t){
        if($t->$key == $where[$key]){
            foreach($values as $k=>$val){
                $t->$k = $val;
                echo $k." ".$val;
                $flag = true;
                //$temp[$keyT] = $t;
                
            }
            
        }

    }
    $temp1->$table->values = $temp;

    write($temp1);
    if($flag == false){
        echo json_encode(["message"=>"Aucun éléments"]);
    }else{
        echo json_encode(["message"=>count($values)." element(s) updated"]);
    }
    
}



if($_SERVER["REQUEST_METHOD"] =="POST"){
    $params = json_decode(file_get_contents("php://input"));
    if(property_exists($params, "table")  && property_exists($params, "where") && property_exists($params,"values")){
        update($params->table, $params->where, $params->values);
    }
}
//update("Users", array("id"=>1), array("name"=>"Gontrand"));

?>