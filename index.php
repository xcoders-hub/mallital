<?php
function directdl2($id) {
    $ch = curl_init("https://drive.google.com/uc?id=$id&export=download");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, []);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    $result = curl_exec($ch);
    $object = json_decode(str_replace(')]}\'', '', $result));
    return ('Location: '. $object->downloadUrl);
}
function skycodes_hash_matxrix($string, $action = 'e') {
    $secret_key = 'Quadplaymovies';
    $secret_iv = 'googleitboss';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
$url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$str = substr(strrchr($url, '/'), 1);
$id = skycodes_hash_matxrix($str, 'd');
echo '<script> window.location.href="'.directdl2($id).'" </script>';

//header('Location: '.directdl2($id).'');

if (empty($id)) {
    echo 'null';
}
