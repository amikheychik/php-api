<?php declare(strict_types=1);

namespace Xtuple\Client\Request;

use Xtuple\Client\Request\URL\URL;
use Xtuple\Util\HTTP\Message\Body\Body;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\SetHeader;
use Xtuple\Util\HTTP\Request\AbstractRequest;
use Xtuple\Util\HTTP\Request\Method\Method;
use Xtuple\Util\HTTP\Request\RequestStruct as HTTPRequestStruct;

final class RequestStruct
  extends AbstractRequest
  implements Request {
  public function __construct(Method $method, URL $url, ?SetHeader $headers = null, ?Body $body = null) {
    parent::__construct(new HTTPRequestStruct($method, $url, $headers, $body));
  }
}
