<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategoriesOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCategoriesUseCaseUnitTest extends TestCase
{

  public function testListCategoriesEmpty()
  {

    $mockPagination = $this->mockPagination();

    $this->mockRepo = Mockery::mock(CategoryRepositoryInterface::class);
    $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination)->times(1);

    $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'desc']);

    $useCase = new ListCategoriesUseCase($this->mockRepo);
    $responseUseCase = $useCase->execute($this->mockInputDto);

    $this->assertCount(0, $responseUseCase->items);
    $this->assertInstanceOf(ListCategoriesOutputDto::class, $responseUseCase);
  }

  public function testListCategories()
  {

    $register = new stdClass();
    $register->id = 'id';
    $register->name = 'name';
    $register->description = 'description';
    $register->is_active = 'is_active';
    $register->created_at = 'created_at';
    $register->updated_at = 'updated_at';
    $register->deleted_at = 'deleted_at';

    $mockPagination = $this->mockPagination([
      $register,
    ]);

    $this->mockRepo = Mockery::mock(CategoryRepositoryInterface::class);
    $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

    $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'desc']);

    $useCase = new ListCategoriesUseCase($this->mockRepo);
    $responseUseCase = $useCase->execute($this->mockInputDto);

    $this->assertCount(1, $responseUseCase->items);
    $this->assertInstanceOf(stdClass::class, $responseUseCase->items[0]);
    $this->assertInstanceOf(ListCategoriesOutputDto::class, $responseUseCase);
  }

  protected function mockPagination(array $items = [])
  {
    $this->mockPagination = Mockery::mock(PaginationInterface::class);
    $this->mockPagination->shouldReceive('items')->andReturn($items);
    $this->mockPagination->shouldReceive('total')->andReturn(0);
    $this->mockPagination->shouldReceive('lastPage')->andReturn(0);
    $this->mockPagination->shouldReceive('firstPage')->andReturn(0);
    $this->mockPagination->shouldReceive('currentPage')->andReturn(0);
    $this->mockPagination->shouldReceive('perPage')->andReturn(0);
    $this->mockPagination->shouldReceive('to')->andReturn(0);
    $this->mockPagination->shouldReceive('from')->andReturn(0);


    return $this->mockPagination;
  }


  protected function tearDown(): void
  {
    Mockery::close();

    parent::tearDown();
  }
}
