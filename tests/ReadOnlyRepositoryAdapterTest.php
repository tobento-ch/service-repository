<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Repository\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Repository\ReadOnlyRepositoryAdapter;
use Tobento\Service\Repository\RepositoryCreateException;
use Tobento\Service\Repository\RepositoryUpdateException;
use Tobento\Service\Repository\RepositoryDeleteException;
use Tobento\Service\Repository\Test\Mock;

/**
 * ReadOnlyRepositoryAdapterTest
 */
class ReadOnlyRepositoryAdapterTest extends TestCase
{
    public function testFindByIdMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entity = $readOnlyRepository->findById(id: 2);
        
        $this->assertSame(2, $entity?->id());
    }
    
    public function testFindByIdsMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entities = $readOnlyRepository->findByIds(1,3,5);
        
        $this->assertSame(2, count($entities));
    }
    
    public function testFindOneMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entity = $readOnlyRepository->findOne(where: ['id' => 2]);
        
        $this->assertSame(2, $entity?->id());
    }
    
    public function testFindAllMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entities = $readOnlyRepository->findAll();
        
        $this->assertSame(3, count($entities));
    }
    
    public function testCountMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $this->assertSame(3, $readOnlyRepository->count());
    }
    
    public function testCreateMethodThrowsCreateException()
    {
        $this->expectException(RepositoryCreateException::class);
        
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entity = $readOnlyRepository->create(['id' => 4]);
    }
    
    public function testUpdateByIdMethodThrowsUpdateException()
    {
        $this->expectException(RepositoryUpdateException::class);
        
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entity = $readOnlyRepository->updateById(id: 2, attributes: ['price' => 3.33]);
    }
    
    public function testUpdateMethodThrowsUpdateException()
    {
        $this->expectException(RepositoryUpdateException::class);
        
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entities = $readOnlyRepository->update(where: ['id' => 2], attributes: ['price' => 3.33]);
    }
    
    public function testDeleteByIdMethodThrowsUpdateException()
    {
        $this->expectException(RepositoryDeleteException::class);
        
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entity = $readOnlyRepository->deleteById(id: 2);
    }
    
    public function testDeleteMethodThrowsUpdateException()
    {
        $this->expectException(RepositoryDeleteException::class);
        
        $repository = new Mock\ProductRepository();
        
        $readOnlyRepository = new ReadOnlyRepositoryAdapter(
            repository: $repository,
        );
        
        $entities = $readOnlyRepository->delete(where: ['id' => 2]);
    }
}