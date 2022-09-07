<?php


include __DIR__."/utils.php";

function findAll($table, $where=NULL){
    if($where==NULL){
        return json_encode(["data"=>read()->$table]);
    }else{
        $where = (array)$where;
        $values= [];
        $key = array_keys($where)[0];
        $temp1 = read();
        $temp = $temp1->$table->values;
        foreach($temp as $t){
            if($t->$key == $where[$key]){
                $values[] = $t;
            
            }
        }
        return json_encode(["data"=>$values]);
    }
    

}
if($_SERVER["REQUEST_METHOD"] =="POST"){
    $params = json_decode(file_get_contents("php://input"));
    if(property_exists($params, "table")  && property_exists($params, "where")){
        echo findAll($params->table, $params->where);
    }
}
//var_dump(findAll("Users"));

?>