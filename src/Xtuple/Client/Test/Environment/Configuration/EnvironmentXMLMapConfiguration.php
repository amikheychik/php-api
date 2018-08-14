<?php declare(strict_types=1);

namespace Xtuple\Client\Test\Environment\Configuration;

use Xtuple\Client\Connection\Test\Environment\Configuration\ConfigurationXMLElement as XtupleConfigurationXMLElement;
use Xtuple\Util\Test\Environment\Configuration\Collection\Map\AbstractMapConfiguration;
use Xtuple\Util\Test\Environment\Configuration\PHPUnitEnvironmentXMLConfiguration;

final class EnvironmentXMLMapConfiguration
  extends AbstractMapConfiguration {
  /**
   * @throws \Throwable
   */
  public function __construct() {
    parent::__construct(
      new PHPUnitEnvironmentXMLConfiguration([
        'xtuple' => XtupleConfigurationXMLElement::class,
      ])
    );
  }
}
