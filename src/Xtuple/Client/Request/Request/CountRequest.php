<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Request;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\Query\Query;
use Xtuple\Client\Request\AbstractRequest;
use Xtuple\Client\Request\URL\ResourceURL;

final class CountRequest
  extends AbstractRequest {
  public function __construct(Connection $connection, string $resource, Query $query) {
    /** @noinspection PhpUnhandledExceptionInspection */
    parent::__construct(new GETRequest(
      new ResourceURL(
        $connection,
        $resource,
        array_diff_key(
          array_merge(array_filter($query->value()), [
            'count' => 1,
          ]),
          [
            'pageToken' => false,
            'maxResults' => false,
          ]
        )
      )
    ));
  }
}
