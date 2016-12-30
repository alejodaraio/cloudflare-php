<?php

namespace CloudFlare\model;

interface ICloudFlare {

  /**
   * ICloudFlare constructor.
   * @param $email
   * @param $key
   * @param $zoneID
   */
  public function __construct($email, $key, $zoneID);

  /**
   * @param array $urls
   * @param array $tags
   * @return mixed
   */
  public function purge_files($urls = array(), $tags = array());

  /**
   * @param $url
   * @param $body
   * @param $method
   * @return mixed
   */
  public function call($url, $body, $method);
}