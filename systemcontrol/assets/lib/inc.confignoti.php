<?php
function sendMessageThroughFCM($arr) {
    //Google Firebase messaging FCM-API url
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = (array) $arr;
    define("GOOGLE_API_KEY","AAAAtjTom_E:APA91bGGpdRilUtayJgs3iATgdprgrkRtLT4y2c27SKhOmQScsWVb8Phx8Ef4XlEUbEOxCuOZpOVs__POIic4ge10yZOTAQE5_q4_bCksKoNyC2IakN-CvLRTKHOuusMoePDmaWLYp1q");
    $headers = array(
        'Authorization: key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if (!$result) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
?>
