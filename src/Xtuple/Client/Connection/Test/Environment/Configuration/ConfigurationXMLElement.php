<?php declare(strict_types=1);

namespace Xtuple\Client\Connection\Test\Environment\Configuration;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\Connection\ConnectionXMLElement;
use Xtuple\Util\XML\Element\XMLElement;

final class ConfigurationXMLElement
  implements Configuration {
  /** @var XMLElement */
  private $element;

  public function __construct(XMLElement $element) {
    $this->element = $element;
  }

  public function xtuple(): Connection {
    return new ConnectionXMLElement($this->element);
  }
}
