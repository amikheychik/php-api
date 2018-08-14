<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromBody;
use Xtuple\Util\JSON\Patch\JSONPatchArray;
use Xtuple\Util\Type\UUID\UUIDv4;

class PATCHRequestTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $etag = (string) new UUIDv4();
    $request = new PATCHRequest(
      new ResourceURL(new PHPUnitConnection('/tmp/key.p12'), 'v1alpha1/address'),
      $etag,
      new JSONPatchArray([
        'thoroughfare' => '119 W York st',
      ], [
        'thoroughfare' => '118 W Bute st',
      ])
    );
    self::assertEquals('PATCH', (string) $request->method());
    self::assertEquals('https://example.com/erp/api/v1alpha1/address', (string) $request->uri());
    self::assertEquals('application/json', $request->headers()->get('Content-Type')->value());
    self::assertEquals(
      strtr('{"etag":"{{ etag }}","patches":[{"op":"replace","path":"/thoroughfare","value":"118 W Bute st"}]}', [
        '{{ etag }}' => $etag,
      ]),
      (string) new StringBodyFromBody($request->body())
    );
  }
}
