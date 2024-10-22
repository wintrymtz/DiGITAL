<?php
header('Content-Type: application/json');
if(isset($_SESSION['email'])){
    echo json_encode($_SESSION['email']);
} else{
    echo json_encode('fail');
}
