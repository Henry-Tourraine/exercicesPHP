<?php
    $questions = "Quel était le surnom d'Édith Piaf ?#Dans la célèbre émission «The Voice», quels sont les quatre coachs ? Garou, Jenifer, Louis Bertignac et...#Qu'ont créé les frères Montgolfier ?#Comment s'appelle le fait de se cogner la nuque contre le siège lors d'un accident de voiture ?#De quel groupe d'humoristes Alain Chabat faisait-il partie ?#De quel pays provient le hamburger ?#Comment Marilyn Monroe s'appelait-elle en réalité ?#Quel fut le deuxième homme à marcher sur la Lune ?#Quel animal (réel ou fictif) porte malheur pour les marins ?#Quelle est la capitale de la Lettonie ?#Que sont les moutons pour les marins ?#Quel gaz existe réellement parmi ces propositions ?#Quel était le plus grand bateau de Christophe Colomb ?#Les diomedeidae sont plus connus sous le nom de :#En quelle année Ludwig van Beethoven est-il né ?";
    $questions = explode("#", $questions);
    $temp = [["1770"=>true,  "1760"=>false,   "1750"=>false,   "1740"=>false],
    [   "Aigles royaux"=>false,  "Albatros"=>true,   "Vautours"=>false,   "Goélands argentés"=>false],
    [  "Le HMS Victory"=>false,   "La Pinta"=>false,   "La Santa-Maria"=>true,   "La Nina"=>false],
    [  "Le gaz moutarde"=>true,   "Le gaz vinaigrette"=>false,   "Le gaz ketchup"=>false,   "Le gaz mayonnaise"=>false],
    [  "Rien d'autre que des animaux"=>false,   "De l'écume blanche"=>true,   "Des pulls fabriqués avec de la laine"=>false,   "Des nuages bien blancs"=>false],
    [ "Kiev"=>false,  "Tallinn"=>false,   "Riga"=>true,   "Vilnius"=>false],
    [ "Le requin"=>false,   "La sirène"=>false,   "Le mouton"=>false,   "Le lapin"=>true], 
    [ "Louis Armstrong"=>false,   "Jim Lovell"=>false,   "Buzz Aldrin"=>true,   "Neil Armstrong"=>false],  
    ["Norman Jean Baker"=>true,   "Norma Jane Baker"=>false,   "Norman Jane Baker"=>false,   "Norma Jean Baker"=>false], 
    ["D'Autriche"=>false,   "De France"=>false,   "D'Allemagne"=>true,   "Des États-Unis"=>false], 
    ["Les Sous-doués"=>false,   "Les Nuls"=>true,   "Éric et Alain"=>false,   "Les Inconnus"=>false],
    [ "Le coup bas"=>false,  "Le coup de l'agneau"=>false,   "Le coup du dragon"=>false,   "Le coup du lapin"=>true], 
    ["L'avion"=>false,   "La montgolfière"=>true,   "Le deltaplane"=>false,   "Le toaster"=>false],
    ["Florent Pagny"=>true,   "Patrick Bruel"=>false,   "Charles Aznavour"=>false,   "Johnny Hallyday"=>false], 
    ["La dragonne"=>false,  "La chèvre"=>false,   "La môme"=>true,   "Le piaf"=>false]];
    $temp = array_reverse($temp);




    if($_SERVER["REQUEST_METHOD"] ==  "POST"){
        $json = json_decode(file_get_contents("php://input"), true);
        $answer = $json["answer"];
        $index = intval($json["index"]);
        
        if(isset($answer) && isset($index)){
            if($temp[$index][$answer] == true){
                echo json_encode(["message"=>true]);
            }else{
                $a = array_search("true", $temp[$index]);
                echo json_encode(["message"=>false, "answer"=>$a]);
            }
        }
    }else{
    
    $index = rand(0, count($questions)-1);
    $answers = "";
    for($i=0; $i<4; $i++){
        $g = array_keys($temp[$index])[$i];
        $answers.="<div id='answer-$i' class='answer'><p>$g</p> </div>";
    }
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qui veut gagner des millions</title>
</head>
<body>
    <style>
        body{
            padding:0;
            margin: 0;
            display: flex;
            flex-flow: column;
            align-items: center;
        }
        .wrapper{
            display: grid;
            grid-template: auto auto / auto auto;
            width: 100%;
            height: 60%;
        }
        .wrapper div{
            padding: 1em;
            
        }
        .wrapper div p:hover{
            background:rgba(200, 50, 50);
            cursor: pointer;
        }
        h2{
            text-align: center;
        }
        p{
            text-align: center;
            display: flex;
            flex-flow: wrap row;
            align-items: center;
            justify-content: center;
            background: rgba(50, 50, 200);
            color: white;
            border-radius: 2vh;
            height: 100%;
        }
        #answer-0{
            grid-area:1/1/2/2;
        }
        #answer{
            grid-area:2/1/3/2;
        }
        #answer-2{
            grid-area:1/2/2/3;
        }
        #answer-3{
            grid-area:2/2/3/3;
        }
        button{
            margin: auto;
            padding: 1em;
            border-radius: 3vh;
            border: none;
            margin: 1em;
            cursor: pointer;
        }
        button:hover{
            background: green;
            color: white;
        }
        .selected{
            background: red;
            color: white;
        }
    </style>
   
      
        
        <h2>$questions[$index]</h2>
        <div class='wrapper'>
            $answers
            </div>
    <button>C'est mon dernier mot, Jean-Pierre</button>
        
    


HTML;
include ("./scripts/exercice13.php");
echo <<<HTM
</body>

</html>
HTM;
}
?>

