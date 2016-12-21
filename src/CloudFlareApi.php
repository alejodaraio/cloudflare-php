<?php

namespace CloudFlareApi;

class CloudFlareApi {

  const API_CLOUDFLARE = 'https://api.cloudflare.com/client/';
  const API_VERSION = 'v4';

  const METHOD_DELETE = "DELETE";
  const METHODS = array(
    self::METHOD_DELETE
  );

  private $email;
  private $key;
  private $zoneID;

  /**
   * CloudFlareApi constructor.
   * @param string $email
   * @param string  $key
   * @param string  $zoneID
   */
  public function __construct($email, $key, $zoneID) {
    $this->email = $email;
    $this->key = $key;
    $this->zoneID = $zoneID;
  }

  /**
   * @param array $urls
   * @param array $tags
   * @throws \Exception
   * @url https://api.cloudflare.com/#zone-purge-individual-files-by-url-and-cache-tags
   */
  public function purge_files($urls = array(), $tags = array()) {

    if (count($urls) > 30) {
      throw new \Exception('The max length to purge files is: 30');
    }

    if (count($tags) > 30) {
      throw new \Exception('The max length to purge tags is: 30');
    }

    $url = $this->cloudflarePath() . '/zones/' . $this->zoneID . '/purge_cache';
    $body = array(
      'files' => $urls,
      'tags' => $tags
    );

    $call = $this->call($url, $body, self::METHOD_DELETE);

  }

  /**
   * @return string
   */
  private function cloudflarePath() {
    return self::API_CLOUDFLARE . self::API_VERSION;
  }

  /**
   * @param $url
   * @param $body
   * @param $method
   * @return mixed
   * @throws \Exception
   */
  private function call($url, $body, $method) {

    if (!in_array($method, self::METHODS)) {
      throw new \Exception('The method ' . $method . ' is not supported');
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    $headers = [
      'X-Auth-Email: ' . $this->email,
      'X-Auth-Key: ' . $this->key,
      'Content-Type: application/json'
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    return json_decode($result);
  }
}