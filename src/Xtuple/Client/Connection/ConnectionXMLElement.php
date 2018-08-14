<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\IssuerStruct;
use Xtuple\Util\XML\Attribute\Type\Boolean\BooleanRequiredXMLAttribute;
use Xtuple\Util\XML\Element\XMLElement;

final class ConnectionXMLElement
  extends AbstractConnection {
  public function __construct(XMLElement $element) {
    parent::__construct(new ConnectionStruct(
      ($attribute = $element->attributes()->get('application')) ? $attribute->value() : '',
      ($attribute = $element->attributes()->get('host')) ? $attribute->value() : '',
      ($attribute = $element->attributes()->get('database')) ? $attribute->value() : '',
      new IssuerStruct(
        ($attribute = $element->attributes()->get('iss'))->value() ? $attribute->value() : ''
      ),
      ($attribute = $element->attributes()->get('key')) ? $attribute->value() : '',
      (new BooleanRequiredXMLAttribute($element->attributes()->get('debug')))->value()
    ));
  }
}
