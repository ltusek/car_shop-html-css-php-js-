<?php
session_start();
if(isset($_SESSION['last_time'])){
    if((time() - $_SESSION['last_time']) > 900){
        $_SESSION = array();
        session_destroy();
    }else{
        $_SESSION['last_time'] = time();
    }
}
