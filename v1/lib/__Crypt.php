<?php
/**This encryption logic is developrd by the help of stack overflow and other such */
function encrypt($string, $unique_id, $iv=null, $key=null, $ciphering=null){
    if(isset($ciphering)){
        $ciphering = $ciphering;
    }else{
        $ciphering = "AES-128-CTR";
    }
    $options = 0;
    if(isset($iv)){
        $encryption_iv = $iv;
    }else{
        $encryption_iv = '2323183745362735';
    }
    if(isset($key)){
        $encryption_key = $key;
    }else{
        $encryption_key = base64_encode(urlencode($unique_id.$encryption_iv));
    }
    $encryptData = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv);
    return $encryptData;
}

function deCrypt($string, $unique_id, $iv=null, $key=null, $ciphering=null){
    if (isset($ciphering)) {
        $ciphering = $ciphering;
    } else {
        $ciphering = "AES-128-CTR";
    }
    $options = 0;
    if (isset($iv)) {
        $decryption_iv = $iv;
    } else {
        $decryption_iv = '2323183745362735';
    }
    if (isset($key)) {
        $decryption_key = $key;
    } else {
        $decryption_key = base64_encode(urlencode($unique_id . $decryption_iv));
    }
    $decryptData = openssl_decrypt($string, $ciphering, $decryption_key, $options, $decryption_iv);
    return $decryptData;
}

?>