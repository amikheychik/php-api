<?php declare(strict_types=1);

namespace Xtuple\Client\Request;

use Xtuple\Util\HTTP\Request\AbstractRequest as AbstractHTTPRequest;

abstract class AbstractRequest
  extends AbstractHTTPRequest
  implements Request {
  public function __construct(Request $request) {
    parent::__construct($request);
  }
}
