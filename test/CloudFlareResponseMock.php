<?php

class CloudFlareResponseMock {

  public $success;
  public $errors = [];
  public $messages = [];
  public $result;

  /**
   * @param string $success
   */
  public function setSuccess($success) {
    $this->success = $success;
  }

  /**
   * @param array $errors
   */
  public function setErrors(Array $errors) {
    $this->errors = $errors;
  }

  /**
   * @param array $messages
   */
  public function setMessages(Array $messages) {
    $this->messages = $messages;
  }

  /**
   * @param stdClass $result
   */
  public function setResult(stdClass $result) {
    $this->result = $result;
  }
}