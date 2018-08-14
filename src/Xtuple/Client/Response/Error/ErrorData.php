<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Error;

use Xtuple\Client\Response\Error\RegEx\ErrorMessageRegEx;
use Xtuple\Util\Type\String\Message\Message\AbstractMessage;
use Xtuple\Util\Type\String\Message\Message\MessageWithTokens;
use Xtuple\Util\Type\String\Message\Type\String\StringMessage;

final class ErrorData
  extends AbstractMessage
  implements Error {
  /** @var string */
  private $trigger;
  /** @var int */
  private $code;

  public function __construct(array $error) {
    $error += ['message' => '', 'code' => 0];
    $matches = (new ErrorMessageRegEx())->matches($error['message']) + [
        'parameters' => '',
      ];
    $message = new StringMessage($error['message']);
    if (isset($matches['message'])) {
      $message = new MessageWithTokens(
        $matches['message'],
        $matches['parameters']
          ? explode(', ', $matches['parameters'])
          : []
      );
    }
    parent::__construct($message);
    $this->trigger = $matches['trigger'] ?? '';
    $this->code = (int) ($matches['code'] ?? $error['code']);
  }

  public function trigger(): string {
    return $this->trigger;
  }

  public function code(): int {
    return $this->code;
  }
}
