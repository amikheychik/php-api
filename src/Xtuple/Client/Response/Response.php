<?php declare(strict_types=1);

namespace Xtuple\Client\Response;

use Xtuple\Util\Collection\Tree\Tree;
use Xtuple\Util\HTTP\Response\JSON\JSONResponse;

interface Response
  extends JSONResponse {
  public function content(): Tree;
}
