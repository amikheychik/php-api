<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromBody;

class POSTRequestTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $request = new POSTRequest(
      new ResourceURL(new PHPUnitConnection('/tmp/key.p12'), 'v1alpha1/address'),
      ['thoroughfare' => '119 W York st']
    );
    self::assertEquals('POST', (string) $request->method());
    self::assertEquals('https://example.com/erp/api/v1alpha1/address', (string) $request->uri());
    self::assertEquals('application/json', $request->headers()->get('Content-Type')->value());
    self::assertEquals(
      '{"thoroughfare":"119 W York st"}',
      (string) new StringBodyFromBody($request->body())
    );
  }
}
