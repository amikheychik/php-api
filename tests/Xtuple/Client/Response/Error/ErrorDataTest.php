<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Error;

use PHPUnit\Framework\TestCase;

class ErrorDataTest
  extends TestCase {
  public function testConstructor() {
    $error = new ErrorData([
      'message' => "The Coupon Code: 'WEB' is not valid. [xdruple: _quoteBeforeUpsertTrigger, -3]",
    ]);
    self::assertEquals("The Coupon Code: 'WEB' is not valid.", (string) $error);
    self::assertEquals('quoteBeforeUpsertTrigger', $error->trigger());
    self::assertEquals(3, $error->code());
    self::assertTrue($error->arguments()->isEmpty());
    $error = new ErrorData([
      'message' => "The Coupon Code: 'WEB' is not valid. [xdruple: _quoteBeforeUpsertTrigger, -3, WEB, TEST, ARGS]",
    ]);
    self::assertEquals("The Coupon Code: 'WEB' is not valid.", (string) $error);
    self::assertEquals('quoteBeforeUpsertTrigger', $error->trigger());
    self::assertEquals(3, $error->code());
    $parameters = [];
    foreach ($error->arguments() as $argument) {
      $parameters[] = (string) $argument;
    }
    self::assertEquals(['WEB', 'TEST', 'ARGS'], $parameters);
    $error = new ErrorData([
      'message' => "The Coupon Code: 'WEB' is not valid.",
      'code' => 2,
    ]);
    self::assertEquals("The Coupon Code: 'WEB' is not valid.", (string) $error);
    self::assertEquals('', $error->trigger());
    self::assertEquals(2, $error->code());
    self::assertTrue($error->arguments()->isEmpty());
  }
}
