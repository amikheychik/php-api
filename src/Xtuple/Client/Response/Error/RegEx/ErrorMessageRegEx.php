<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Error\RegEx;

use Xtuple\Util\RegEx\AbstractRegEx;
use Xtuple\Util\RegEx\RegExPattern;

final class ErrorMessageRegEx
  extends AbstractRegEx {
  public function __construct() {
    parent::__construct(new RegExPattern('/
      ^(?P<message>(?:.*))\ \[
        (?:xtuple|xdruple):\ _?(?P<trigger>(?:\w+)),\ -?(?P<code>(?:\d+))
      (?:\]|,\ (?P<parameters>(?:.*))\])$
    /x'));
  }
}
