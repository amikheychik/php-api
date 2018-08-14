<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Error\RegEx;

use PHPUnit\Framework\TestCase;

class ErrorMessageRegExTest
  extends TestCase {
  public function testRegEx() {
    $regex = new ErrorMessageRegEx();
    $message = "The Coupon Code: 'WEB' is not valid. [xdruple: _quoteBeforeUpsertTrigger, -3]";
    self::assertEquals("The Coupon Code: 'WEB' is not valid.", $regex->matches($message)['message']);
    self::assertEquals('quoteBeforeUpsertTrigger', $regex->matches($message)['trigger']);
    self::assertEquals(3, (int) $regex->matches($message)['code']);
    $message = "The Coupon Code: 'WEB' is not valid. [xdruple: _quoteBeforeUpsertTrigger, -3, WEB, TEST, ARGS]";
    self::assertEquals("The Coupon Code: 'WEB' is not valid.", $regex->matches($message)['message']);
    self::assertEquals('quoteBeforeUpsertTrigger', $regex->matches($message)['trigger']);
    self::assertEquals(3, (int) $regex->matches($message)['code']);
    self::assertEquals('WEB, TEST, ARGS', $regex->matches($message)['parameters']);
  }
}
