<script>
console.log("loaded");

let a;
let answers = [...document.querySelectorAll(".answer")].map(e=>e.querySelector("p"));
[...answers].forEach(e=>e.addEventListener("click", (e)=>{
    [...answers].forEach(ee=>{
        if(ee.classList.contains("selected")){
            ee.classList.remove("selected")
        }
        
    })
    e.target.classList.add("selected");
    a = e.target.textContent;
    console.log(a);
}))
let button = document.querySelector("button");
button.addEventListener("click", ()=>{

    fetch(window.location.href, {method: "POST", headers: {'Accept': "application/json", 'Content-Type': "application/json"}, body: JSON.stringify({index: <?=$index ?>,answer: a})})
    .then(e=>e.json())
    .then(e=>{console.log(e); 
        if(e.message == true){
            document.querySelector(".selected").style.background = "green";
            alert("Bravo vous avez réussi");
            
        }else{
            alert("Mauvaise réponse");
            Array.from(document.querySelectorAll("p"))
            .find(el => el.textContent.includes(e.answer)).style.background = "green";
            console.log(e.answer);
        }
        setTimeout(()=>location.reload(), 1000);
    })
})
            
</script>