<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Registered\ExpirationTime;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\Type\DateTime\DateTimeTimestampSeconds;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampStruct;

class ExpirationTimeFromTimestampTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $claim = new ExpirationTimeFromTimestamp(
      new TimestampStruct(1534192554)
    );
    self::assertEquals('1534196154', $claim->value());
    self::assertEquals('exp', $claim->name());
    self::assertEquals('exp: 1534196154', (string) $claim);
    self::assertTrue($claim->datetime()->equals(new DateTimeTimestampSeconds(1534196154)));
  }
}
