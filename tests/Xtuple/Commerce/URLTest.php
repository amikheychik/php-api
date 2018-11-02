<?php declare(strict_types=1);

namespace Xtuple\Commerce;

use Xtuple\Client\Request\Request\DELETERequest;
use Xtuple\Client\Request\Request\GETRequest;
use Xtuple\Client\Request\Request\POSTRequest;
use Xtuple\Client\Request\Request\PUTRequest;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Client\Test\ERPClientTestCase;

class URLTest
  extends ERPClientTestCase {
  /**
   * @throws \Throwable
   */
  public function testCRUD() {
    $url = [
      'url' => 'https://www.xtuple.com/',
      'title' => 'xTuple',
      'published' => false,
      'contentType' => null,
      'weight' => 0,
    ];
    $created = $this->environment->client()->send(new POSTRequest(
      new ResourceURL($this->environment->connection(), 'v2/urls'),
      $url
    ))->response()->content()->data();
    self::assertArrayHasKey('id', $created);
    self::assertArrayHasKey('uuid', $created);
    $read = $this->environment->client()->send(new GETRequest(
      new ResourceURL($this->environment->connection(), "v2/urls/{$created['uuid']}")
    ))->response()->content()->data();
    self::assertEquals($created, $read);
    $e = null;
    try {
      $this->environment->client()->send(new GETRequest(
        new ResourceURL($this->environment->connection(), "v2/urls/{$created['id']}")
      ));
    }
    catch (\Throwable $e) {
      self::assertNotNull($e->getPrevious());
      self::assertEquals('Not Found', $e->getPrevious()->getMessage());
    }
    finally {
      if ($e !== null) {
        self::fail('v2/urls/:uuid route responded to read by URL id request');
      }
    }
    self::assertFalse($read['published']);
    self::assertEquals(0, $read['weight']);
    $read['published'] = true;
    $read['weight'] = 1;
    $updated = $this->environment->client()->send(new PUTRequest(
      new ResourceURL($this->environment->connection(), "v2/urls/{$read['uuid']}"),
      $read
    ))->response()->content()->data();
    self::assertTrue($updated['published']);
    self::assertEquals(1, $updated['weight']);
    $deleted = $this->environment->client()->send(new DELETERequest(
      new ResourceURL($this->environment->connection(), "v2/urls/{$updated['uuid']}")
    ))->response()->content()->data();
    self::assertTrue($deleted['deleted']);
    self::assertEquals($updated['uuid'], $deleted['uuid']);
    $e = null;
    try {
      $this->environment->client()->send(new GETRequest(
        new ResourceURL($this->environment->connection(), "v2/urls/{$deleted['uuid']}")
      ))->response()->content()->data();
    }
    catch (\Throwable $e) {
      self::assertNotNull($e->getPrevious());
      self::assertEquals('Not Found', $e->getPrevious()->getMessage());
    }
    finally {
      if ($e === null) {
        self::fail('v2/urls/:uuid route loaded deleted URL');
      }
    }
  }
}
