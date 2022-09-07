<?php
    if(isset($_COOKIE["auth"])){
        header("Location: ./");
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <label for="">Name</label>
        <input type="text" id="name">
        <label for="">Pwd</label>
        <input type="text" id="pwd">
        <button>Se connecter</button>
        <a href="./signin.php">Je n'ai pas de compte</a>
    </div>
    <script>
        let nameDOM = document.querySelector("#name");
        
        let pwdDOM = document.querySelector("#pwd");
        let name;
        let pwd;
        nameDOM.addEventListener("input", (e)=>{
            name = e.target.value;
        })
        pwdDOM.addEventListener("input", (e)=>{
            pwd= e.target.value;
        })
        let button = document.querySelector("button");
        button.addEventListener("click", ()=>{
            if(pwd !== undefined && name !== undefined && name.length > 2 && pwd.length > 2){
                fetch("./dbUtils/signup.php", {method: "POST", headers: {'Accept': "application/json", 'Content-Type': "application/json"}, body: JSON.stringify({name: name, pwd: pwd, table: "Users"})})
                .then(e=>e.text())
                .then(e=>{
                    console.log(e);
                    if(e.message ==true){
                        alert("Vous vous êtes inscrit !");
                        window.location.href = "./auth.php";
                    }
                })
            }
        })
    </script>
</body>
</html>