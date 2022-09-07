
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <style>
        .todosWrapper{
            padding: 2em;
            display: flex;
            flex-flow: wrap row;

        }
        .todos{
            padding: 1em;
            background: rgba(250, 240, 210, 1);
            border-radius: 3vh;
            margin: 2em;
        }
    </style>
    <a href="./">Mon compte</a>
<?php
    require './dbUtils/findAll.php';
    $cookie = json_decode($_COOKIE["auth"], true);
    $list = json_decode(findAll("Lists"), true)["data"]["values"];
    $users = json_decode(findAll("Users"), true)["data"]["values"];
    //var_dump($list);
    //var_dump($users);
    function f($id){
        global $users;
        forEach($users as $user){
            if($user['id'] == $id){
                return $user;
            }
            return false;
        }
    }
    echo "<div class='todosWrapper'>";


    forEach($list as $l){
        $u = f($l["user_id"]);
     
        if($u !==false){
            $c= $l["value"]?"checked":"";
            echo "<div class='todos'>";
            echo "<br/> user: ".$u["name"];
            echo "<div> tâche: {$l['name']} </div> <input type='checkbox' {$c}/>";
            echo "</div>";
        }
      
    }
    echo "</div>";



?>
</body>
</html>