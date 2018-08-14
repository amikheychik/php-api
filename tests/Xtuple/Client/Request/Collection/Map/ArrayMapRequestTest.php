<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Collection\Map;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\Request\Request\GETRequest;
use Xtuple\Client\Request\URL\ResourceURL;

class ArrayMapRequestTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $connection = new PHPUnitConnection('/tmp/key.p12');
    $requests = new class (new ArrayMapRequest([
      'addresses' => new GETRequest(new ResourceURL($connection, 'v1alpha1/address')),
      new GETRequest(new ResourceURL($connection, 'v1alpha1/contact')),
    ]))
      extends AbstractMapRequest {
    };
    self::assertFalse($requests->isEmpty());
    self::assertEquals(2, $requests->count());
    self::assertEquals('https://example.com/erp/api/v1alpha1/address', (string) $requests->get('addresses')->uri());
    self::assertEquals('https://example.com/erp/api/v1alpha1/contact', (string) $requests->get('0')->uri());
  }
}
