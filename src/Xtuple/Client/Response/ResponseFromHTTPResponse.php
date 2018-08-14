<?php declare(strict_types=1);

namespace Xtuple\Client\Response;

use Xtuple\Util\Collection\Tree\ArrayTree\ArrayTree;
use Xtuple\Util\Collection\Tree\Tree;
use Xtuple\Util\HTTP\Response\JSON\AbstractJSONResponse;
use Xtuple\Util\HTTP\Response\JSON\JSONResponseStruct;
use Xtuple\Util\HTTP\Response\Response as HTTPResponse;

final class ResponseFromHTTPResponse
  extends AbstractJSONResponse
  implements Response {
  public function __construct(HTTPResponse $response) {
    parent::__construct(new JSONResponseStruct($response));
  }

  public function content(): Tree {
    try {
      return $this->json();
    }
    catch (\Throwable $e) {
      return new ArrayTree();
    }
  }
}
