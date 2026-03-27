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
use Tobento\Service\Repository\NullRepository;
use Tobento\Service\Repository\RepositoryInterface;

class NullRepositoryTest extends TestCase
{
    public function testImplementsRepositoryInterface(): void
    {
        $repo = new NullRepository();
        $this->assertInstanceOf(RepositoryInterface::class, $repo);
    }

    public function testFindByIdReturnsNull(): void
    {
        $repo = new NullRepository();
        $this->assertNull($repo->findById(1));
        $this->assertNull($repo->findById('abc'));
    }

    public function testFindByIdsReturnsEmptyIterable(): void
    {
        $repo = new NullRepository();
        $result = $repo->findByIds(1, 2, 3);

        $this->assertIsIterable($result);
        $this->assertSame([], iterator_to_array($result));
    }

    public function testFindOneReturnsNull(): void
    {
        $repo = new NullRepository();
        $this->assertNull($repo->findOne(['name' => 'Alice']));
    }

    public function testFindAllReturnsEmptyIterable(): void
    {
        $repo = new NullRepository();
        $result = $repo->findAll(['active' => true]);

        $this->assertIsIterable($result);
        $this->assertSame([], iterator_to_array($result));
    }

    public function testFindColumnReturnsEmptyArray(): void
    {
        $repo = new NullRepository();
        $this->assertSame([], $repo->findColumn('name'));
        $this->assertSame([], $repo->findColumn('name', 'id'));
    }

    public function testCountReturnsZero(): void
    {
        $repo = new NullRepository();
        $this->assertSame(0, $repo->count());
        $this->assertSame(0, $repo->count(['active' => true]));
    }

    public function testCreateReturnsObjectWithAttributes(): void
    {
        $repo = new NullRepository();

        $entity = $repo->create(['name' => 'Alice', 'age' => 30]);

        $this->assertIsObject($entity);
        $this->assertSame('Alice', $entity->name);
        $this->assertSame(30, $entity->age);
    }

    public function testUpdateByIdReturnsObjectWithAttributes(): void
    {
        $repo = new NullRepository();

        $entity = $repo->updateById(5, ['name' => 'Bob']);

        $this->assertIsObject($entity);
        $this->assertSame('Bob', $entity->name);
    }

    public function testUpdateReturnsEmptyIterable(): void
    {
        $repo = new NullRepository();
        $result = $repo->update(['active' => true], ['name' => 'Updated']);

        $this->assertIsIterable($result);
        $this->assertSame([], iterator_to_array($result));
    }

    public function testDeleteByIdReturnsObjectWithId(): void
    {
        $repo = new NullRepository();

        $entity = $repo->deleteById(10);

        $this->assertIsObject($entity);
        $this->assertSame(10, $entity->id);
    }

    public function testDeleteReturnsEmptyIterable(): void
    {
        $repo = new NullRepository();
        $result = $repo->delete(['active' => false]);

        $this->assertIsIterable($result);
        $this->assertSame([], iterator_to_array($result));
    }
}