<?php
function get_random_proxy()
{
    srand ((double)microtime()*1000000);
    $f_contents = file ("https://yoursite.com/proxy.txt");
    $line = $f_contents[array_rand ($f_contents)];
    return $line;
}
function directdl2($id) {
    $ch = curl_init("https://drive.google.com/uc?id=$id&authuser=0&export=download");
    $proxy =  get_random_proxy();
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POSTFIELDS => [],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_PROXY => $proxy
        CURLOPT_ENCODING => 'gzip,deflate',
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        CURLOPT_HTTPHEADER => ['accept-encoding: gzip, deflate, br',
            'content-length: 0',
            'content-type: application/x-www-form-urlencoded;charset=UTF-8',
            'origin: https://drive.google.com',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
            'x-client-data: CKG1yQEIkbbJAQiitskBCMS2yQEIqZ3KAQioo8oBGLeYygE=',
            'x-drive-first-party: DriveWebUi',
            'x-json-requested: true']
    ));
    $response = curl_exec($ch);
    $object = json_decode(str_replace(')]}\'', '', $response), true);
    return $object['downloadUrl'];
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
