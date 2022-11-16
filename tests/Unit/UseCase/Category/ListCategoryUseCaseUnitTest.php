<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

class ListCategoryUseCaseUnitTest extends TestCase
{

  public function testGetById()
  {
    $id = (string) Uuid::uuid4()->toString();

    $this->mockEntity = Mockery::mock(Category::class, [$id, 'test category']);

    $this->mockEntity->shouldReceive('id')->andReturn($id);
    $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

    $this->mockRepo = Mockery::mock(CategoryRepositoryInterface::class);
    $this->mockRepo->shouldReceive('findById')
      ->once()
      ->with($id)
      ->andReturn($this->mockEntity);

    $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [
      $id
    ]);

    $useCase = new ListCategoryUseCase($this->mockRepo);
    $response = $useCase->execute($this->mockInputDto);

    $this->assertInstanceOf(CategoryOutputDto::class, $response);
    $this->assertEquals('test category', $response->name);
    $this->assertEquals($id, $response->id);

    /**
     * Spies
     */

    $this->spy = Mockery::spy(CategoryRepositoryInterface::class);
    $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
    $useCase = new ListCategoryUseCase($this->spy);
    $useCase->execute($this->mockInputDto);
    $this->spy->shouldHaveReceived('findById');

    Mockery::close();
  }
}
