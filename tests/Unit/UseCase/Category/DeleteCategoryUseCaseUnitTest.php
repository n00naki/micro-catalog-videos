<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryDeleteOutputDto;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

class DeleteCategoryUseCaseUnitTest extends TestCase
{

  public function testDelete()
  {
    $uuid = (string) Uuid::uuid4()->toString();

    $this->mockRepo = Mockery::mock(CategoryRepositoryInterface::class);
    $this->mockRepo->shouldReceive('delete')
      ->andReturn(true)
      ->times(1);

    $useCase = new DeleteCategoryUseCase($this->mockRepo);

    $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [$uuid]);

    $reponseUseCase = $useCase->execute($this->mockInputDto);

    $this->assertInstanceOf(CategoryDeleteOutputDto::class, $reponseUseCase);
    $this->assertTrue($reponseUseCase->success);
  }

  public function testDeleteFalse()
  {
    $uuid = (string) Uuid::uuid4()->toString();

    $this->mockRepo = Mockery::mock(CategoryRepositoryInterface::class);
    $this->mockRepo->shouldReceive('delete')->andReturn(false);

    $useCase = new DeleteCategoryUseCase($this->mockRepo);

    $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [$uuid]);

    $reponseUseCase = $useCase->execute($this->mockInputDto);

    $this->assertInstanceOf(CategoryDeleteOutputDto::class, $reponseUseCase);
    $this->assertFalse($reponseUseCase->success);
  }

  protected function tearDown(): void
  {
    Mockery::close();

    parent::tearDown();
  }
}
