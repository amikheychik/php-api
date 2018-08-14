<?php declare(strict_types=1);

namespace Xtuple\Client\Response;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromBody;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromString;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Message\Header\Header\ContentType\JSONContentTypeHeader;
use Xtuple\Util\HTTP\Response\ResponseStruct;
use Xtuple\Util\HTTP\Response\Status\StatusStruct;
use Xtuple\Util\Type\UUID\UUIDv4;

class ResponseFromHTTPResponseTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $uuid = (string) new UUIDv4();
    $http = new ResponseStruct(
      new StatusStruct('1.1', 200, 'OK'),
      new ArraySetHeader([
        new JSONContentTypeHeader(),
      ]),
      new JSONBodyData([
        'etag' => $uuid,
        'data' => [
          'line1' => '119 W York st',
          'line2' => '',
          'city' => 'Norfolk',
          'state' => 'VA',
        ],
      ])
    );
    $response = new ResponseFromHTTPResponse($http);
    self::assertEquals(200, $response->status()->code());
    self::assertEquals('OK', $response->status()->reason());
    self::assertEquals('application/json', $response->headers()->get('Content-Type')->value());
    self::assertEquals(
      strtr('{"etag":"{{ etag }}","data":{"line1":"119 W York st","line2":"","city":"Norfolk","state":"VA"}}', [
        '{{ etag }}' => $uuid,
      ]),
      (string) new StringBodyFromBody($response->body())
    );
    self::assertEquals([
      'etag' => $uuid,
      'data' => [
        'line1' => '119 W York st',
        'line2' => '',
        'city' => 'Norfolk',
        'state' => 'VA',
      ],
    ], $response->content()->data());
    self::assertEquals([
      'etag' => $uuid,
      'data' => [
        'line1' => '119 W York st',
        'line2' => '',
        'city' => 'Norfolk',
        'state' => 'VA',
      ],
    ], $response->json()->data());
  }

  /**
   * @expectedException \Xtuple\Util\HTTP\Message\Body\String\JSON\Exception\JSONException
   * @expectedExceptionMessage Syntax error
   * @throws \Throwable
   */
  public function testJSONParsingError() {
    $response = new ResponseFromHTTPResponse(
      new ResponseStruct(
        new StatusStruct('1.1', 200, 'OK'),
        new ArraySetHeader([
          new JSONContentTypeHeader(),
        ]),
        new StringBodyFromString('{json:"Broken"}')
      )
    );
    self::assertEquals([], $response->content()->data());
    self::assertEquals([], $response->json()->data());
  }
}
