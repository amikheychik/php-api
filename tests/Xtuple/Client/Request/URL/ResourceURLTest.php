<?php declare(strict_types=1);

namespace Xtuple\Client\Request\URL;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Connection\Test\PHPUnitConnection;

class ResourceURLTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $url = new ResourceURL(new PHPUnitConnection('/tmp/key.p12'), 'v2/address');
    self::assertEquals('https://example.com/erp/api/v2/address', (string) $url);
  }
}
