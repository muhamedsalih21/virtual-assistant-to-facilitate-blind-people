<?php

function dedection($body){

$headers = array(
    // application/json is also a valid content-type
    // but in my case I had to set it to octet-steam
    // for I am trying to send a binary image
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: cc1d0ce88dd244ebadfd14fa827a5e46'
);
$curl = curl_init();

curl_setopt($curl, CURLOPT_FRESH_CONNECT, true); // don't cache curl request
curl_setopt($curl, CURLOPT_URL, 'https://westcentralus.api.cognitive.microsoft.com/vision/v1.0/analyze?visualFeatures=Categories,Description,Color&language=en&model=landmarks');
curl_setopt($curl, CURLOPT_POST, true); // http POST request
// if content-type is set to application/json, the POSTFIELDS should be:json_encode(array('url' => $body))
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('url' => $body)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return the transfer as a string of the return value
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// disabling SSL checks may not be needed, in my case though I had to do it
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($curl);
$curlError = curl_error($curl);
return $response.$curlError;
curl_close($curl);
}

function face($body){

$headers = array(
    // application/json is also a valid content-type
    // but in my case I had to set it to octet-steam
    // for I am trying to send a binary image
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: bca94fc5b80248d080a86ed50c5a8ee5'
);
$curl = curl_init();

curl_setopt($curl, CURLOPT_FRESH_CONNECT, true); // don't cache curl request
curl_setopt($curl, CURLOPT_URL, 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false&returnFaceAttributes=age,gender,smile,facialHair,glasses,makeup');
curl_setopt($curl, CURLOPT_POST, true); // http POST request
// if content-type is set to application/json, the POSTFIELDS should be:json_encode(array('url' => $body))
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('url' => $body)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return the transfer as a string of the return value
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// disabling SSL checks may not be needed, in my case though I had to do it
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($curl);
$curlError = curl_error($curl);
return $response.$curlError;
curl_close($curl);
}



function emotion($body){
$headers = array(
    // application/json is also a valid content-type
    // but in my case I had to set it to octet-steam
    // for I am trying to send a binary image
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: ab9a0567d3e74c199dce8757053f475f'
);
$curl = curl_init();

curl_setopt($curl, CURLOPT_FRESH_CONNECT, true); // don't cache curl request
curl_setopt($curl, CURLOPT_URL, 'https://westus.api.cognitive.microsoft.com/emotion/v1.0/recognize');
curl_setopt($curl, CURLOPT_POST, true); // http POST request
// if content-type is set to application/json, the POSTFIELDS should be:json_encode(array('url' => $body))
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('url' => $body)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return the transfer as a string of the return value
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// disabling SSL checks may not be needed, in my case though I had to do it
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($curl);
$curlError = curl_error($curl);
return $response.$curlError;
curl_close($curl);
}


// $apidata[]= dedection("http://www.rmkec.ac.in/dem/bpa/upload/cat.png");
// $apidata[]=face("http://dreamicus.com/data/face/face-04.jpg");
// $apidata[]=emotion("http://dreamicus.com/data/face/face-04.jpg");
// print_r(json_encode($apidata));
?>