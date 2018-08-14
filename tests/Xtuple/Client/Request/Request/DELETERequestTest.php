<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromBody;

class DELETERequestTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $request = new DELETERequest(new ResourceURL(new PHPUnitConnection('/tmp/key.p12'), 'v2/contact/1'));
    self::assertEquals('DELETE', (string) $request->method());
    self::assertEquals('https://example.com/erp/api/v2/contact/1', (string) $request->uri());
    self::assertTrue($request->headers()->isEmpty());
    self::assertEquals('', (string) new StringBodyFromBody($request->body()));
  }
}
