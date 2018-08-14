<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\Query\BuildQuery;
use Xtuple\Client\Query\Condition\Collection\Map\ArrayMapCondition;
use Xtuple\Client\Query\Condition\Condition\AtLeast;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromBody;

class CountRequestTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $request = new CountRequest(
      new PHPUnitConnection('/tmp/key.p12'),
      'v2/contact',
      new BuildQuery(
        new ArrayMapCondition([
          new AtLeast('price', 10.00),
        ])
      )
    );
    self::assertEquals('GET', (string) $request->method());
    self::assertEquals(
      'https://example.com/erp/api/v2/contact?query%5Bprice%5D%5BAT_LEAST%5D=10&count=1',
      (string) $request->uri()
    );
    self::assertTrue($request->headers()->isEmpty());
    self::assertEquals('', (string) new StringBodyFromBody($request->body()));
  }
}
