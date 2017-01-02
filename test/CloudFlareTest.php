<?php

namespace CloudFlareTest;

use PHPUnit_Framework_TestCase;
use CloudFlare\CloudFlare;
use CloudFlare\CloudFlareException;

/**
 * Class CloudFlareTest
 * @coversDefaultClass CloudFlare
 * @package CloudFlareTest
 */
class CloudFlareTest extends PHPUnit_Framework_TestCase {

  /**
   * @var CloudFlare $client
   */
  private $client;

  /**
   * Start up the initial config for tests
   */
  protected function setUp() {
    parent::setUp();
  }

  /**
   * CloudFlareApiTest constructor.
   * @param null $name
   * @param array $data
   * @param string $dataName
   */
  public function __construct($name = NULL, array $data = [], $dataName = '') {
    parent::__construct($name, $data, $dataName);

    $this->client = new CloudFlare('user@email.com', '234567543345', '232456543234');
  }

  /**
   *
   */
  public function testCallExists() {
    $this->assertTrue(
      method_exists($this->client, 'call'),
      'Class does not have method call'
    );
  }

  /**
   *
   */
  public function testPurgeFileMaxFiles() {

    $urls = array();
    $tags = array();

    for ($i = 0; $i <= 35; $i++) {
      $urls[] = 'http://www.mock-' . uniqid() . '.com';
    }

    try {
      $this->client->purge_files($urls, $tags);
    } catch (CloudFlareException $e) {
      $this->assertInstanceOf(CloudFlareException::class, $e, $e->getMessage());
      $this->assertEquals('The max length to purge files is: ' . CloudFlare::MAX_FILES, $e->getMessage());
    }
  }

  /**
   *
   */
  public function testMethodDelete() {
    $this->assertArraySubset(array('DELETE'), CloudFlare::METHODS);
  }

  /**
   *
   */
  public function testPurgeFileSuccess() {

    $cfMock = $this->getMockBuilder(CloudFlare::class)
      ->setConstructorArgs(array('mock@mail.com','mockKey','mockZoneId'))
      ->setMethods(array('call'))
      ->getMock();

    $cfResult = new CloudFlareMockResult(TRUE);
    $cfMock->expects($this->once())->method('call')->willReturn($cfResult->getResult());

    $files = array('http://mymock.com/mock');
    $tags = array();

    $this->assertTrue($cfMock->purge_files($files, $tags));
  }

  /**
   * @expectedException \CloudFlare\CloudFlareException
   */
  public function testPurgeFileFail() {

    $cfMock = $this->getMockBuilder(CloudFlare::class)
      ->setConstructorArgs(array('mock@mail.com','mockKey','mockZoneId'))
      ->setMethods(array('call'))
      ->getMock();

    $cfResult = new CloudFlareMockResult(FALSE);
    $cfMock->expects($this->once())->method('call')->willReturn($cfResult->getResult());

    $files = array('http://mymock.com/mock');
    $tags = array();

    $this->assertTrue($cfMock->purge_files($files, $tags));
  }
}