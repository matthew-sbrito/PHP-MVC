<?php

namespace App\Http;

class SendRequest {

  public static function get($url, $token = false){
    $curl = curl_init();

    $headers = [
      'Authorization: ' . $token ? $token : '',
    ];

    curl_setopt_array($curl, [
      CURLOPT_URL             => $url,
      CURLOPT_CUSTOMREQUEST   => 'GET',
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_HTTPHEADER      => $headers,
    ]);

    $response = curl_exec($curl);
    $response = json_decode($response, true);

    curl_close($curl);

    return $response;
  }
  public static function post($url, $body, $token = false)
  {
    $curl = curl_init();

    $headers = [
      'Authorization: '.$token ? $token : '',
      'Content-Type: application/json',
    ];

    curl_setopt_array($curl, [
      CURLOPT_URL             => $url,
      CURLOPT_CUSTOMREQUEST   => 'POST',
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_HTTPHEADER      => $headers,
      CURLOPT_POSTFIELDS      => json_encode($body),
    ]);

    $response = curl_exec($curl);
    $response = json_decode($response, true);

    curl_close($curl);

    return $response;
  }
}