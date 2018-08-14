<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use Xtuple\Client\Request\AbstractRequest;
use Xtuple\Client\Request\RequestStruct;
use Xtuple\Client\Request\URL\URL;
use Xtuple\Util\HTTP\Message\Body\Body;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\SetHeader;
use Xtuple\Util\HTTP\Request\Method\Method\DELETE;

final class DELETERequest
  extends AbstractRequest {
  public function __construct(URL $url, ?SetHeader $headers = null, ?Body $body = null) {
    parent::__construct(new RequestStruct(new DELETE(), $url, $headers, $body));
  }
}
