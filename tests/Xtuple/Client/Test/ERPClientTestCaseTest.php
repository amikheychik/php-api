<?php declare(strict_types=1);

namespace Xtuple\Client\Test;

class ERPClientTestCaseTest
  extends ERPClientTestCase {
  protected function setUp() {
    try {
      parent::setUp();
    }
    catch (\Throwable $e) {
    }
  }

  protected function setUpEnvironment($configuration) {
    parent::setUpEnvironment($configuration);
    return null;
  }

  public function testSkipOnEnvironmentFailure() {
    self::assertNull($this->environment);
  }
}
