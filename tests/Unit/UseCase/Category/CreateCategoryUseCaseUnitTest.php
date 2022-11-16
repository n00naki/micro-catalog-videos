<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\CategoryCreateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

class CreateCategoryUseCaseUnitTest extends TestCase
{

  public function testCreateNewCategory()
  {
    $uuid = (string) Uuid::uuid4()->toString();

    $categoryName = 'name cat';

    $this->mockEntity = Mockery::mock(Category::class, [$uuid, $categoryName]);

    $this->mockEntity->shouldReceive('id')->andReturn($uuid);
    $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

    $this->mockRepo = Mockery::mock(CategoryRepositoryInterface::class);
    $this->mockRepo->shouldReceive('insert')
      ->andReturn($this->mockEntity)
      ->times(1);


    $useCase = new CreateCategoryUseCase($this->mockRepo);

    $this->mockInputDto = Mockery::mock(CategoryCreateInputDto::class, [$categoryName]);

    $reponseUseCase = $useCase->execute($this->mockInputDto);

    $this->assertInstanceOf(CategoryCreateOutputDto::class, $reponseUseCase);
    $this->assertEquals($categoryName, $reponseUseCase->name);
    $this->assertEquals('', $reponseUseCase->description);

    Mockery::close();
  }
}
