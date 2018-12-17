<?php declare(strict_types=1);

namespace Xtuple\Commerce;

use Xtuple\Client\Request\Request\GETRequest;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Client\Test\ERPClientTestCase;

class ConfigurationTest
  extends ERPClientTestCase {
  /**
   * @throws \Throwable
   */
  public function testRead() {
    $data = $this->environment->client()->send(new GETRequest(
      new ResourceURL($this->environment->connection(), 'v2/configuration')
    ))->response()->json()->data();
    self::assertArrayHasKey('honorific', $data);
    self::assertArrayHasKey('shipVia', $data);
    self::assertArrayHasKey('warehouse', $data);
    self::assertArrayHasKey('terms', $data);
    self::assertArrayHasKey('country', $data);
    self::assertArrayHasKey('customerType', $data);
    self::assertArrayHasKey('remitTo', $data);
  }
}
