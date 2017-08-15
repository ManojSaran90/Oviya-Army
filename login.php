<?php 


        if (isset($_GET['uname']) && isset($_GET['psw'])) {
       $num1=$_GET['num1'];
       $num2=$_GET['num2'];
       $sum=$num1 + $num2;
       echo $num1 . "+". $num2 . "=" .$sum;   # code...
    } 
 ?>