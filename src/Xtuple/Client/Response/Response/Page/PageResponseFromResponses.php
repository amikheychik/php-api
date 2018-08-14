<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Response\Page;

use Xtuple\Client\Query\Query;
use Xtuple\Client\Response\Pager\Page\PageStruct;
use Xtuple\Client\Response\Pager\Pager;
use Xtuple\Client\Response\Pager\PagerStruct;
use Xtuple\Client\Response\Response;
use Xtuple\Util\Collection\Tree\ArrayTree\ArrayTree;
use Xtuple\Util\Collection\Tree\Tree;
use Xtuple\Util\Exception\Exception;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Response\JSON\AbstractJSONResponse;
use Xtuple\Util\HTTP\Response\JSON\JSONResponseStruct;
use Xtuple\Util\HTTP\Response\ResponseStruct;

final class PageResponseFromResponses
  extends AbstractJSONResponse
  implements PageResponse {
  /** @var array */
  private $content;

  /**
   * @throws Throwable
   *
   * @param Query    $query
   * @param Response $count
   * @param Response $list
   */
  public function __construct(Query $query, Response $count, Response $list) {
    if ($list->content()->get(['nameSpace'])) {
      $this->content = $list->content()->data();
    }
    else {
      // v1 output compatibility
      $this->content = $list->content()->get(['data']);
    }
    if (!isset($this->content['data'])
      || !is_array($this->content['data'])) {
      throw new Exception('No data returned, array expected');
    }
    $countResponse = $count->content();
    if (empty($countResponse->get(['data']))) {
      throw new Exception('Count request failed to return any data');
    }
    $this->content = array_merge([
      'pager' => [
        'total' => $countResponse->get(['data', 'data', 0, 'count']) ?: $countResponse->get(['data', 0, 'count']),
        'size' => $query->value()['maxResults'] ?? count($this->content['data']),
        'page' => ($query->value()['pageToken'] ?? 0) + 1,
      ],
    ], $this->content);
    parent::__construct(new JSONResponseStruct(new ResponseStruct(
      $list->status(),
      $list->headers(),
      new JSONBodyData($this->content)
    )));
  }

  public function content(): Tree {
    return new ArrayTree($this->content);
  }

  public function data(): array {
    return $this->content['data'];
  }

  public function etags(): array {
    return $this->content['etags'] ?? [];
  }

  public function pager(): Pager {
    return new PagerStruct(
      new PageStruct(
        (int) $this->content['pager']['size'],
        (int) $this->content['pager']['page']
      ),
      (int) $this->content['pager']['total']
    );
  }
}
