<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Response\Page;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Query\BuildQuery;
use Xtuple\Client\Query\Limit\LimitStruct;
use Xtuple\Client\Response\ResponseFromHTTPResponse;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Message\Header\Header\ContentType\JSONContentTypeHeader;
use Xtuple\Util\HTTP\Response\ResponseStruct;
use Xtuple\Util\HTTP\Response\Status\StatusStruct;
use Xtuple\Util\Type\UUID\UUIDv4;

class PageResponseFromResponsesTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructorV2() {
    $response = new PageResponseFromResponses(
      new BuildQuery(null, null, new LimitStruct(30)),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData([
            'data' => [
              [
                'count' => 40,
              ],
            ],
          ])
        )
      ),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData([
            'nameSpace' => 'product',
            'data' => [
              1 => [
                'id' => 1,
                'title' => 'Product 1',
              ],
            ],
          ])
        )
      )
    );
    self::assertEquals([], $response->etags());
    self::assertEquals([
      1 => [
        'id' => 1,
        'title' => 'Product 1',
      ],
    ], $response->data());
    self::assertEquals([
      'nameSpace' => 'product',
      'data' => [
        1 => [
          'id' => 1,
          'title' => 'Product 1',
        ],
      ],
      'pager' => [
        'total' => 40,
        'size' => 30,
        'page' => 1,
      ],
    ], $response->content()->data());
    self::assertEquals(40, $response->pager()->total());
    self::assertEquals(1, $response->pager()->page()->number());
    self::assertEquals(30, $response->pager()->page()->size());
  }

  /**
   * @throws \Throwable
   */
  public function testConstructorV1() {
    $uuid = (string) new UUIDv4();
    $response = new PageResponseFromResponses(
      new BuildQuery(null, null, new LimitStruct(30, 2)),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData([
            'data' => [
              [
                'count' => 40,
              ],
            ],
          ])
        )
      ),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData([
            'data' => [
              'nameSpace' => 'product',
              'data' => [
                1 => [
                  'id' => 1,
                  'title' => 'Product 1',
                ],
              ],
              'etags' => [
                1 => $uuid,
              ],
            ],
          ])
        )
      )
    );
    self::assertEquals([
      1 => $uuid,
    ], $response->etags());
    self::assertEquals([
      1 => [
        'id' => 1,
        'title' => 'Product 1',
      ],
    ], $response->data());
    self::assertEquals(40, $response->pager()->total());
    self::assertEquals(2, $response->pager()->page()->number());
    self::assertEquals(30, $response->pager()->page()->size());
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage No data returned, array expected
   * @throws \Throwable
   */
  public function testEmptyListResponseException() {
    new PageResponseFromResponses(
      new BuildQuery(null, null, new LimitStruct(30, 2)),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData()
        )
      ),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData()
        )
      )
    );
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Count request failed to return any data
   * @throws \Throwable
   */
  public function testEmptyCountResponseException() {
    new PageResponseFromResponses(
      new BuildQuery(null, null, new LimitStruct(30, 2)),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData()
        )
      ),
      new ResponseFromHTTPResponse(
        new ResponseStruct(
          new StatusStruct('1.1', 200, 'OK'),
          new ArraySetHeader([
            new JSONContentTypeHeader(),
          ]),
          new JSONBodyData([
            'nameSpace' => 'XM',
            'data' => [],
          ])
        )
      )
    );
  }
}
