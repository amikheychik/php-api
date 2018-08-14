<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use Xtuple\Client\Request\AbstractRequest;
use Xtuple\Client\Request\RequestStruct;
use Xtuple\Client\Request\URL\URL;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Message\Header\Header\ContentType\JSONContentTypeHeader;
use Xtuple\Util\HTTP\Request\Method\Method\POST;

final class POSTRequest
  extends AbstractRequest {
  public function __construct(URL $url, array $data) {
    /** @noinspection PhpUnhandledExceptionInspection - $headers types are verified */
    parent::__construct(new RequestStruct(new POST(), $url, new ArraySetHeader([
      new JSONContentTypeHeader(),
    ]), new JSONBodyData($data)));
  }
}
