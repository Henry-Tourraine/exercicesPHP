<?php
if($_SERVER["REQUEST_METHOD"] =="POST"){
        $y = json_decode(file_get_contents("php://input"), true);
        $numberOfDices = intval($y['numberOfDices']);
        $temp = [];
        for($i = 0; $i<$numberOfDices; $i++){
            $temp[] = rand(1, 6);
        }
        echo json_encode(["data"=>$temp]);
        
    
}else{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dices</title>
    </head>
    <body>
        <form action="" method="POST">
            <input type="number" id="numberOfDices" name="numberOfDices">
            <button type="submit" name="submit">Lancer</button>
        </form>
        <ul id="result"></ul>
        <script>
            let f = document.querySelector("form");
            let result = document.querySelector("#result");
            f.addEventListener("submit", (e)=>{
                e.preventDefault();
                let r = document.querySelector("[name='numberOfDices'");
                fetch(window.location.href, {method: "POST", headers: {'Accept': "application/json", 'Content-Type': "application/json"}, body: JSON.stringify({numberOfDices: r.value})})
                .then(e=>e.json())
                .then(e=>{console.log(e); 
                result.innerHTML = e.data.map(p=>{return"<li>"+p+"</li>"}).join(" ");
            });
            })
        </script>
    </body>
    </html>
HTML;    
}



?>