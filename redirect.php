<?php

function redirect1($url, $statusCode = 303){
   header('Location: ' . $url, true, $statusCode);
   die();
}


?>
