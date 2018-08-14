<?php declare(strict_types=1);

namespace Xtuple\Client\Result;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\HTTP\Client\Result\ResultWithResponse;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Message\Header\Header\ContentType\JSONContentTypeHeader;
use Xtuple\Util\HTTP\Response\ResponseStruct;
use Xtuple\Util\HTTP\Response\Status\StatusStruct;

class ResultFromHTTPResultTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
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
    self::assertEquals('test', $result->key());
    self::assertEquals([
      'id' => 1,
      'title' => 'Example',
    ], $result->response()->content()->data());
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage ERP response contains an error
   * @throws \Throwable
   */
  public function testErrorResponseException() {
    $result = new ResultFromHTTPResult(new ResultWithResponse('test', new ResponseStruct(
      new StatusStruct('1.1', 200, 'OK'),
      new ArraySetHeader([
        new JSONContentTypeHeader(),
      ]),
      new JSONBodyData([
        'error' => [
          'message' => "The Coupon Code: 'WEB' is not valid. [xdruple: _quoteBeforeUpsertTrigger, -3]",
          'code' => 1,
        ],
      ])
    )));
    try {
      $result->response();
    }
    catch (\Throwable $e) {
      throw $e->getPrevious();
    }
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Not found
   * @throws \Throwable
   */
  public function testErrorHTTPCode() {
    $result = new ResultFromHTTPResult(new ResultWithResponse('test', new ResponseStruct(
      new StatusStruct('1.1', 404, 'Not found'),
      new ArraySetHeader([
        new JSONContentTypeHeader(),
      ]),
      new JSONBodyData()
    )));
    try {
      $result->response();
    }
    catch (\Throwable $e) {
      throw $e->getPrevious();
    }
  }
}
