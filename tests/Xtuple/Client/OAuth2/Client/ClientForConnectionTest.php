<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client;

use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\OAuth2\Client\Token\Scope\ScopeStruct;
use Xtuple\Client\Request\Request\GETRequest;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Client\Test\ERPClientTestCase;
use Xtuple\Util\Cache\Cache\Memory\MemoryCache;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyFromBody;
use Xtuple\Util\Type\UUID\UUIDv4;

class ClientForConnectionTest
  extends ERPClientTestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $oauth2 = new ClientForConnection(
      $this->environment->connection(),
      new MemoryCache('tokens'),
      new ScopeStruct((string) new UUIDv4()),
      new SubjectForCustomer()
    );
    $request = new GETRequest(new ResourceURL($this->environment->connection(), 'v2/products'));
    $result = $oauth2->send($request);
    $response = new JSONBodyFromBody($result->response()->body());
    self::assertEquals('XDRUPLE', $response->data()->get(['nameSpace']));
  }
}
