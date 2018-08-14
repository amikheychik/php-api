<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Collection\Map;

use Xtuple\Client\Request\Request;

interface MapRequest
  extends \Xtuple\Util\HTTP\Request\Collection\Map\MapRequest {
  /**
   * @return null|Request
   *
   * @param string $key
   */
  public function get(string $key);

  /**
   * @return null|Request
   */
  public function current();
}
