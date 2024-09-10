<?php
function hashpassword($text){
    return password_hash($text, PASSWORD_BCRYPT);

}

function verifiPassword($text, $hash){
return password_verify($text, $hash);
}