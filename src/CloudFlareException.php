<?php

namespace  CloudFlare;

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
