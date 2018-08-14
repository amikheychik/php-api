<?php declare(strict_types=1);

namespace Xtuple\Client\Result\Collection\Map;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Result\ResultFromHTTPResult;
use Xtuple\Util\HTTP\Client\Result\ResultWithResponse;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Message\Header\Header\ContentType\JSONContentTypeHeader;
use Xtuple\Util\HTTP\Response\ResponseStruct;
use Xtuple\Util\HTTP\Response\Status\StatusStruct;

class ArrayMapResultTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $results = new class (new ArrayMapResult())
      extends AbstractMapResult {
    };
    self::assertEquals(0, $results->count());
    self::assertTrue($results->isEmpty());
    $result = new ResultFromHTTPResult(new ResultWithResponse('test', new ResponseStruct(
      new StatusStruct('1.1', 200, 'OK'),
      new ArraySetHeader([
        new JSONContentTypeHeader(),
      ]),
      new JSONBodyData([
        'id' => 1,
        'title' => 'Example',
      ])
    )));
    $results = new class (new ArrayMapResult([
      $result,
    ]))
      extends AbstractMapResult {
    };
    self::assertNotNull($results->get('test'));
    self::assertEquals([
      'id' => 1,
      'title' => 'Example',
    ], $results->get('test')->response()->content()->data());
  }
}
