<?php declare(strict_types=1);

namespace Xtuple\Client;

use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\OAuth2\Client\AccessToken\Scope\ScopeStruct;
use Xtuple\Client\Request\Collection\Map\ArrayMapRequest;
use Xtuple\Client\Request\Request\GETRequest;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Client\Test\ERPClientTestCase;
use Xtuple\Util\Cache\Cache\Memory\MemoryCache;

class ERPClientTest
  extends ERPClientTestCase {
  /**
   * @throws \Throwable
   */
  public function testSend() {
    $result = $this->environment->client()->send(new GETRequest(
      new ResourceURL($this->environment->connection(), 'v2/products')
    ));
    self::assertEquals('XDRUPLE', $result->response()->content()->get(['nameSpace']));
  }

  /**
   * @expectedException  \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Failed ERP request
   * @throws \Throwable
   */
  public function testSendException() {
    $this->environment->client()->send(new GETRequest(
      new ResourceURL($this->environment->connection(), 'v0/not-found')
    ))->response();
  }

  /**
   * @throws \Throwable
   */
  public function testSendMany() {
    $results = $this->environment->client()->sendMany(new ArrayMapRequest([
      'products' => new GETRequest(
        new ResourceURL($this->environment->connection(), 'v2/products')
      ),
      'cart' => new GETRequest(
        new ResourceURL($this->environment->connection(), 'v2/cart')
      ),
    ]));
    self::assertEquals('XDRUPLE', $results->get('products')->response()->content()->get(['nameSpace']));
    self::assertEquals('CART::EMPTY', $results->get('cart')->response()->content()->get(['opportunityStage']));
  }

  /**
   * @expectedException  \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage HTTP requests failed
   * @throws \Throwable
   */
  public function testSendManyException() {
    $client = new ERPClient(
      $this->environment->connection(),
      new MemoryCache('tokens'),
      new SubjectForCustomer('GUEST'),
      new ScopeStruct('erp', 'session')
    );
    $client->sendMany(new ArrayMapRequest([
      new GETRequest(
        new ResourceURL($this->environment->connection(), 'v0/not-found')
      ),
      new GETRequest(
        new ResourceURL($this->environment->connection(), 'v0/access-denied')
      ),
    ]));
  }
}
