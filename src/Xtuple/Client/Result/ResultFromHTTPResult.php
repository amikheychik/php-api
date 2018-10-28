<?php declare(strict_types=1);

namespace Xtuple\Client\Result;

use Xtuple\Client\Response\Error\ErrorData;
use Xtuple\Client\Response\Response;
use Xtuple\Client\Response\ResponseFromHTTPResponse;
use Xtuple\Util\Exception\ChainException;
use Xtuple\Util\Exception\Exception;
use Xtuple\Util\Exception\MultiErrorException;
use Xtuple\Util\HTTP\Client\Result\Result as HTTPResult;

final class ResultFromHTTPResult
  implements Result {
  /** @var HTTPResult */
  private $result;

  public function __construct(HTTPResult $result) {
    $this->result = $result;
  }

  public function key(): string {
    return $this->result->key();
  }

  public function response(): Response {
    try {
      $status = $this->result->response()->status();
      if ($status->code() >= 400) {
        throw new Exception($status->reason(), [], $status->code());
      }
      $response = new ResponseFromHTTPResponse($this->result->response());
      if ($error = $response->json()->get(['error'])) {
        $error = new ErrorData($error);
        /** @noinspection PhpUnhandledExceptionInspection */
        throw new MultiErrorException([$error], 'ERP response contains an error', [], $error->code());
      }
      return $response;
    }
    catch (\Throwable $e) {
      throw new ChainException($e, 'Failed ERP request');
    }
  }
}
