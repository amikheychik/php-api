<?php declare(strict_types=1);

namespace Xtuple\Commerce;

use Xtuple\Client\Request\Request\GETRequest;
use Xtuple\Client\Request\URL\ResourceURL;
use Xtuple\Client\Test\ERPClientTestCase;

class ProductTest
  extends ERPClientTestCase {
  /**
   * @throws \Throwable
   */
  public function testRead() {
    /** @var array[] $products */
    $products = $this->environment->client()->send(new GETRequest(
      new ResourceURL($this->environment->connection(), 'v2/products')
    ))->response()->content()->data()['data'];
    $product = $this->environment->client()->send(new GETRequest(
      new ResourceURL($this->environment->connection(), "v2/products/{$products[0]['id']}")
    ))->response()->content()->data()['data'];
    self::assertEquals($product['id'], $products[0]['id']);
    self::assertEquals($product, $products[0]);
  }
}
