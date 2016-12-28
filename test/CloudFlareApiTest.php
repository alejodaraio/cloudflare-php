<?php

require_once '/app/src/CloudFlareApi.php';
require_once '/app/test/CloudFlareResponseMock.php';

use CloudFlareApi\CloudFlareApi;
use CloudFlareApi\CloudFlareException;

class CloudFlareApiTest extends PHPUnit_Framework_TestCase {

  /**
  * @var CloudFlareApi $client
  */
  private $client;


  /**
   * CloudFlareApiTest constructor.
   * @param null $name
   * @param array $data
   * @param string $dataName
   */
  public function __construct($name = NULL, array $data = [], $dataName = '') {
    parent::__construct($name, $data, $dataName);

    $this->client = new CloudFlareApi('user@email.com','234567543345','232456543234');
  }

  protected function setUp()
  {
    parent::setUp();
  }

  public function testCallExists() {
    $this->assertTrue(
      method_exists($this->client, 'call'),
      'Class does not have method call'
    );
  }

  public function testPurgeFileMaxFiles() {

    $urls = array();
    $tags = array();

    for($i=0; $i <= 35; $i++) {
      $urls[] = 'http://www.mock-' . uniqid() . '.com';
    }

    try {
      $this->client->purge_files($urls, $tags);
    } catch(CloudFlareException $e) {
      $this->assertInstanceOf(CloudFlareException::class, $e, $e->getMessage());
    }
  }

  public function testPurgeFileSuccess() {

    $stub = $this->createMock(CloudFlareApi::class);
    $stub->method('purge_files')->willReturn(true);

    $files = array('http://mymock.com/mock');
    $tags = array();
    $this->assertTrue($stub->purge_files($files, $tags));
  }
}