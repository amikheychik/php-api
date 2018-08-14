<?php declare(strict_types=1);

namespace Xtuple\Client\Result\Collection\Map;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\HTTP\Client\Result\Collection\Map\ArrayMapResult as ArrayMapHTTPResult;
use Xtuple\Util\HTTP\Client\Result\ResultWithResponse;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Message\Header\Header\ContentType\JSONContentTypeHeader;
use Xtuple\Util\HTTP\Response\ResponseStruct;
use Xtuple\Util\HTTP\Response\Status\StatusStruct;

class MapResultFromMapHTTPResultTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $results = new MapResultFromMapHTTPResult(new ArrayMapHTTPResult([]));
    self::assertEquals(0, $results->count());
    self::assertTrue($results->isEmpty());
    $results = new MapResultFromMapHTTPResult(new ArrayMapHTTPResult([
      new ResultWithResponse('test', new ResponseStruct(
        new StatusStruct('1.1', 200, 'OK'),
        new ArraySetHeader([
          new JSONContentTypeHeader(),
        ]),
        new JSONBodyData([
          'id' => 1,
          'title' => 'Example',
        ])
      )),
    ]));
    self::assertEquals('test', $results->get('test')->key());
    self::assertEquals([
      'id' => 1,
      'title' => 'Example',
    ], $results->get('test')->response()->content()->data());
  }
}
