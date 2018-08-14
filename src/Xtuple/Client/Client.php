<?php declare(strict_types=1);

namespace Xtuple\Client;

use Xtuple\Client\Request\Collection\Map\MapRequest;
use Xtuple\Client\Request\Request;
use Xtuple\Client\Result\Collection\Map\MapResult;
use Xtuple\Client\Result\Result;

interface Client {
  public function send(Request $request): Result;

  /**
   * @throws \Throwable
   *
   * @param MapRequest $requests
   *
   * @return MapResult
   */
  public function sendMany(MapRequest $requests): MapResult;
}
