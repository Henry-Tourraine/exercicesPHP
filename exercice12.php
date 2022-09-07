<?php

    class DateParts{
        private $date;
        public function __construct(DateTime $e){
            $this->date =  $e;
            
            
        }
       function getDate(){
            return $this->date->format('d-m-y h:i:s');
       }
        public function getYear(){
            return $this->date->format("Y");
           
        }
        function getMonth(){
            return $this->date->format("m");
        }
        function getDay(){
            return $this->date->format("d");
        }
        function getHours(){
            return $this->date->format("h");
        }
        function getMinutes(){
            return $this->date->format("i");
        }
        function getSeconds(){
            return $this->date->format("s");
        }

        function add($d){
            $r = array_keys($d);
            $temp = ["getYear"=> 0, "getMonth"=>0, "getDay"=>0, "getHours"=>0, "getMinutes"=>0, "getSeconds"=>0];
            foreach($r as $key){
                $temp[$key] = $d[$key];
            }
            return new DateParts(new DateTime($this->getYear()+$temp["getYear"]."-".$this->getMonth()+$temp["getMonth"]."-".$this->getDay()+$temp["getDay"]." ".$this->getHours()+$temp["getHours"].":".$this->getMinutes()+$temp["getMinutes"].":".$this->getSeconds()+$temp["getSeconds"]));
        }
        function addTimestamp($d){
            $d = $this->date->getTimestamp()+$d;
            $temp = new DateTime();
            $temp->setTimestamp($d);
            $temp = new DateParts($temp);
            return $temp;
        }
        
    }

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice 12</title>
</head>
<body>
    <h2>Date et heure</h2>
    <?php echo date('d-m-y h:i:s'); ?>
    <h2>Date, il y a deux jours</h2>
    <!-- TIMESTAMP is in second not millisecond -->
    <?php echo date('d-m-y h:i:s', time()-(2*24*60*60)); ?>
    <h2>Date, un an et 30 jours plus tard</h2>
    <!-- TIMESTAMP is in second not millisecond -->
<?php 
    $e = new DateTime();
    $r = new DateParts($e);
    $p = new DateTime($r->getYear()."-".intval($r->getMonth()+1)."-".$r->getDay()." ".$r->getHours().":".$r->getMinutes().":".$r->getSeconds());
    //echo $p->format('d-m-y h:i:s');
    echo "<br/>";
    //ADD ONE YEAR
    $t = $r->add(["getYear"=>1]);
    //ADD 30 DAYS
    echo $t->addTimestamp(30*24*60*60)->getDate();
    echo "<br/> <br/>traditional way <br/>";
    $date=new DateTime();
    date_add($date,date_interval_create_from_date_string("1 year 30 days"));
    echo date_format($date,"d-m-y h:i:s");
?>

</body>
</html>