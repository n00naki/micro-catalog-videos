<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryUpdateInputDto;
use Core\UseCase\DTO\Category\CategoryUpdateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

class UpdateCategoryUseCaseUnitTest extends TestCase
{

  public function testRenameCategory()
  {
    $uuid = (string) Uuid::uuid4()->toString();

    $categoryName = 'name cat';

    $this->mockEntity = Mockery::mock(Category::class, [$uuid, $categoryName]);
    $this->mockEntity->shouldReceive('update');

    $this->mockEntity->shouldReceive('id')->andReturn($uuid);
    $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

    $this->mockRepo = Mockery::mock(CategoryRepositoryInterface::class);
    $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
    $this->mockRepo->shouldReceive('update')->andReturn($this->mockEntity)->times(1);

    $useCase = new UpdateCategoryUseCase($this->mockRepo);

    $this->mockInputDto = Mockery::mock(CategoryUpdateInputDto::class, [$uuid, $categoryName]);

    $reponseUseCase = $useCase->execute($this->mockInputDto);

    $this->assertInstanceOf(CategoryUpdateOutputDto::class, $reponseUseCase);

    Mockery::close();
  }
}
