<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Registered\Subject;

use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\AbstractSubject;
use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\SubjectStruct;

final class SubjectForCustomer
  extends AbstractSubject {
  public function __construct(string $subject = 'admin') {
    parent::__construct(new SubjectStruct(strtolower($subject)));
  }
}
