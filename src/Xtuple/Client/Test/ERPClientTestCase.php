<?php declare(strict_types=1);

namespace Xtuple\Client\Test;

use Xtuple\Client\Connection\Test\Environment\Configuration\Configuration;
use Xtuple\Client\Test\Environment\Environment;
use Xtuple\Client\Test\Environment\EnvironmentStruct;
use Xtuple\Util\Test\AbstractTestCase;

/**
 * @property Environment $environment
 */
abstract class ERPClientTestCase
  extends AbstractTestCase {
  protected function environmentName(): string {
    return 'ERP connection';
  }

  protected function configurationType(): string {
    return Configuration::class;
  }

  protected function setUpEnvironment($configuration) {
    return new EnvironmentStruct($configuration);
  }
}
