<?php

namespace CloudFlareApi;

use Exception;

class CloudFlareException extends Exception {

  /**
   * CloudFlareException constructor.
   * @param string $message
   * @param int $code
   * @param \Exception|NULL $previous
   */
  public function __construct($message = "", $code = 0, Exception $previous = NULL) {
    parent::__construct($message, $code, $previous);
  }

}

class CloudFlareApi {

  const API_CLOUDFLARE = 'https://api.cloudflare.com/client/';
  const API_VERSION = 'v4';
  const MAX_FILES = 30;
  const MAX_TAGS = 30;

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
   * @return bool
   * @throws CloudFlareException
   * @url https://api.cloudflare.com/#zone-purge-individual-files-by-url-and-cache-tags
   */
  public function purge_files($urls = array(), $tags = array()) {

    if (count($urls) > self::MAX_FILES) {
      throw new CloudFlareException('The max length to purge files is: ' . self::MAX_FILES);
    }

    if (count($tags) > self::MAX_TAGS) {
      throw new CloudFlareException('The max length to purge tags is: ' . self::MAX_TAGS);
    }

    $url = $this->cloudflarePath() . '/zones/' . $this->zoneID . '/purge_cache';
    $body = array(
      'files' => $urls,
      'tags' => $tags
    );

    $call = $this->call($url, $body, self::METHOD_DELETE);

    if($call->success !== true) {
      $error = $call->errors[0];
      throw new CloudFlareException($error->message, $error->code);
    }

    return true;
  }

  /**
   * @return string
   */
  private function cloudflarePath() {
    return self::API_CLOUDFLARE . self::API_VERSION;
  }

  /**
   * @param string $url
   * @param array $body
   * @param string $method
   * @return mixed
   * @throws CloudFlareException
   */
  public function call($url, $body, $method) {

    if (!in_array($method, self::METHODS)) {
      throw new CloudFlareException('The method ' . $method . ' is not supported');
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