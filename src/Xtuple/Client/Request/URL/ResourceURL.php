<?php declare(strict_types=1);

namespace Xtuple\Client\Request\URL;

use Xtuple\Client\Connection\Connection;
use Xtuple\Util\HTTP\Request\URI\URL\AbstractBaseURL;

final class ResourceURL
  extends AbstractBaseURL
  implements URL {
  public function __construct(Connection $connection, string $resource, array $query = [], string $fragment = '') {
    parent::__construct("{$connection->url()}/api", $resource, $query, $fragment);
  }
}
