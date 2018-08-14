<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Registered\Subject;

use PHPUnit\Framework\TestCase;

class SubjectForCustomerTest
  extends TestCase {
  public function testConstructor() {
    $subject = new SubjectForCustomer();
    self::assertEquals('admin', $subject->value());
    self::assertEquals('sub', $subject->name());
    self::assertEquals('sub: admin', (string) $subject);
    $subject = new SubjectForCustomer('TESTER@XTUPLE.COM');
    self::assertEquals('tester@xtuple.com', $subject->value());
    self::assertEquals('sub', $subject->name());
    self::assertEquals('sub: tester@xtuple.com', (string) $subject);
  }
}
