<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationUnitTest extends TestCase
{

  const message = 'custom message error';

  public function testNotNull()
  {

    try {
      $value = '';

      DomainValidation::notNull($value);

      $this->assertTrue(false);
    } catch (Throwable $th) {

      $this->assertInstanceOf(EntityValidationException::class, $th);
    }
  }

  public function testNotNullCustomMessageException()
  {

    try {
      $value = '';

      DomainValidation::notNull($value, DomainValidationUnitTest::message);

      $this->assertTrue(false);
    } catch (Throwable $th) {

      $this->assertInstanceOf(EntityValidationException::class, $th, DomainValidationUnitTest::message);
    }
  }

  public function testStrMaxLength()
  {

    try {
      $value = 'teste';

      DomainValidation::strMaxLength($value, 5, DomainValidationUnitTest::message);

      $this->assertTrue(false);
    } catch (Throwable $th) {

      $this->assertInstanceOf(EntityValidationException::class, $th, DomainValidationUnitTest::message);
    }
  }

  public function testStrMinLength()
  {

    try {
      $value = 'tes';

      DomainValidation::strMinLength($value, 5, DomainValidationUnitTest::message);

      $this->assertTrue(false);
    } catch (Throwable $th) {

      $this->assertInstanceOf(EntityValidationException::class, $th, DomainValidationUnitTest::message);
    }
  }

  public function testStrCanNullAndMaxLength()
  {

    try {
      $value = 'teste';

      DomainValidation::strCanNullAndMaxLength($value, 3, DomainValidationUnitTest::message);

      $this->assertTrue(false);
    } catch (Throwable $th) {

      $this->assertInstanceOf(EntityValidationException::class, $th, DomainValidationUnitTest::message);
    }
  }
}
