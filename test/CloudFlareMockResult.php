<?php

namespace CloudFlareTest;

class CloudFlareMockResult {
  public $success;
  public $errors = array();
  public $messages = array();

  /**
   * CloudFlareMockResult constructor.
   * @param bool $success
   */
  function __construct($success = false) {
    $this->success = $success;
    $this->makeError();
  }

  /**
   * @return $this
   */
  public function getResult() {
    return $this;
  }

  /**
   * Create a mock error
   */
  private function makeError() {
    if($this->success == FALSE) {
      $this->errors[] = (new CloudFlareMockResultError(403))->getError();
    }
  }
}

class CloudFlareMockResultError {

  public $code;
  public $message;

  /**
   * CloudFlareMockResultError constructor.
   * @param integer $code
   * @param string $message
   */
  function __construct($code = 0, $message = "") {
    $this->code = $code;
    $this->message = $message;
  }

  /**
   * @return $this
   */
  function getError() {
    return $this;
  }
}