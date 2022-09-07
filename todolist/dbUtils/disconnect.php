<?php
if($_COOKIE["auth"]){
    setcookie("auth", "", time()-3600, '/');
    

}
header("Location: ./");


?>