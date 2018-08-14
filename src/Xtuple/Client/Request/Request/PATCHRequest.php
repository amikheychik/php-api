<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use Xtuple\Client\Request\AbstractRequest;
use Xtuple\Client\Request\RequestStruct;
use Xtuple\Client\Request\URL\URL;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Message\Header\Header\ContentType\JSONContentTypeHeader;
use Xtuple\Util\HTTP\Request\Method\Method\PATCH;
use Xtuple\Util\JSON\Patch\JSONPatch;

final class PATCHRequest
  extends AbstractRequest {
  public function __construct(URL $url, string $etag, JSONPatch $patch) {
    /** @noinspection PhpUnhandledExceptionInspection - $headers types are verified */
    parent::__construct(new RequestStruct(new PATCH(), $url, new ArraySetHeader([
      new JSONContentTypeHeader(),
    ]), new JSONBodyData([
      'etag' => $etag,
      'patches' => $patch,
    ])));
  }
}
