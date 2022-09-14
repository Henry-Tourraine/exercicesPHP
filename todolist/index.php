<?php

require './dbUtils/findAll.php';
if(!isset($_COOKIE["auth"])){
    header("Location: ./auth.php");
}
if($_SERVER["REQUEST_METHOD"] =="POST"){
    echo "POST";
}else{
    $cookie = json_decode($_COOKIE["auth"], true);
    $todos = json_decode(findAll("Lists", ["user_id"=>$cookie["id"]]), true)["data"];
    $ht="";
    forEach($todos as $todo){
        $t ="";
        if($todo['value']){
            $t= 'checked';
        }
        $ht .= <<<TODO
        <div class="task">
       
            <input type='text' class="updateName" value="{$todo['name']}" />
            <input type='checkbox' class="updateValue" {$t}/>
            <button data-id={$todo['id']} class="buttonUpdate">Mettre à jour</button>
            <button data-id={$todo['id']} class="buttonDelete">Détruire</button>
        </div>
    TODO;    
    }
   
    
    echo <<<HTML
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your TodoList</title>
</head>
<body>
    <button id="deco">Déconnexion</button>
    <a href="./dashboard.php">Dashboard</a>
    <h2>Mon compte</h2>
    <div>
        <label for="">Ajouter une tâche</label><br/>
        <input type="text" id="task"><br/>
        <label id="label">à faire</label><br/>
        <input type="checkbox" id="check"><br/>
        <button id="add">Ajouter</button>
        <div id="result" style="color: green"></div><br/><br/>
</div>
<hr/>
<label for="">Modifier</label>
<div class="todos">
    {$ht}

</div>

    <script>
        let result = document.querySelector("#result");
        
        function getCookie(name) {
            let c = document.cookie;
            console.log(c);
            c = c.split(";");
            return c.map(e=>{let b = {};b[e.split("=")[0]]= JSON.parse(decodeURIComponent(e.split("=")[1])); return b})
        }
        let cookies = getCookie("auth");
        console.log(cookies);
        let deco = document.querySelector("#deco");
        deco.addEventListener("click", ()=>{
    document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });
            window.location.href = "./";
        })
        let label = document.querySelector("#label");
        let but = document.querySelector("#add");
        let taskDOM = document.querySelector("#task");
        let checkDOM = document.querySelector("#check");
        let task;
        taskDOM.addEventListener("input",(e)=>{
            task = e.target.value;
        })
        checkDOM.addEventListener("input",(e)=>{
            check = e.target.checked;
            console.log(e.target.checked);
            if(e.target.checked == true){
                label.innerHTML = "fait";
            }else{
                label.innerHTML = "à faire";
            }
        })

        but.addEventListener("click", ()=>{
            console.log("send");
            if(task.length >1){
                fetch("./dbUtils/addTask.php", {method: "POST", headers: {'Accept': "application/json", 'Content-Type': "application/json"}, body: JSON.stringify({name: task, check: check, user_id:cookies[0].auth.id })})
                .then(e=>e.json())
                .then(e=>{
                    console.log("send"+e);
                    if(e.message ==true){
                       result.innerHTML = "Votre tâche a bien été ajoutée";
                       setTimeout(()=>{result.innerHTML= ""; window.location.reload()}, 500);
                    }
                })
            }
        })

        //UPDATE
        let updateButtons = [...document.querySelectorAll(".task")].map(e=>{return e.querySelector(".buttonUpdate")});
        console.log(updateButtons);
        updateButtons.forEach(b=>b.addEventListener("click", (e)=>{
            console.log(b.parentNode.querySelector(".updateName").value);
            let data = {table: "Lists",where: {id: b.dataset.id}, values:{name: b.parentNode.querySelector(".updateName").value, value: b.parentNode.querySelector(".updateValue").checked}};
            fetch("./dbUtils/update.php", {method: "POST",  headers: {'Accept': "application/json", 'Content-Type': "application/json"}, body: JSON.stringify(data)})
            .then(e=>e.text())
            .then(e=>{console.log(e); window.location.reload()})
        })
        )

        //DELETE
     
        let deleteButtons = [...document.querySelectorAll(".task")].map(e=>{return e.querySelector(".buttonDelete")});
        console.log(updateButtons);
        deleteButtons.forEach(b=>b.addEventListener("click", (e)=>{
            console.log(b.parentNode.querySelector(".updateName").value);
            let data = {table: "Lists",where: {id: b.dataset.id}, value: b.parentNode.querySelector(".updateValue").checked};
            fetch("./dbUtils/delete.php", {method: "POST",  headers: {'Accept': "application/json", 'Content-Type': "application/json"}, body: JSON.stringify(data)})
            .then(e=>e.text())
            .then(e=>{console.log(e);window.location.reload()})
        })
        )
    </script>
</body>
</html>
HTML;    
}


?>

