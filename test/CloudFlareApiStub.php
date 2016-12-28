<?php
use CloudFlareApi\CloudFlareApi;
use CloudFlareApi\CloudFlareException;


class CloudFlareApiStub extends CloudFlareApi {

  public function __construct($email, $key, $zoneID) {
    parent::__construct($email, $key, $zoneID);
  }

  public function purge_files($urls = array(), $tags = array()) {

  }

  protected function call($url, $body, $method) {
    if (!in_array($method, self::METHODS)) {
      throw new CloudFlareException('The method ' . $method . ' is not supported');
    }
    return $this;
  }

}