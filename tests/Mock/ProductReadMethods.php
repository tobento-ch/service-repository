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

namespace Tobento\Service\Repository\Test\Mock;

use Tobento\Service\Repository\ReadRepositoryInterface;

/**
 * Read methods, just for testing purposes.
 */
trait ProductReadMethods
{
    /**
     * Returns the found entity using the specified id (primary key)
     * or null if none found.
     *
     * @param int|string $id
     * @return null|object
     * @throws RepositoryReadException
     */
    public function findById(int|string $id): null|ProductEntity
    {
        $filtered = array_filter($this->products, fn(ProductEntity $p) => $p->id() === $id);
        
        return $filtered[array_key_first($filtered)] ?? null;
    }
    
    /**
     * Returns the found entity using the specified id (primary key)
     * or null if none found.
     *
     * @param int|string ...$ids
     * @return iterable<object>
     * @throws RepositoryReadException
     */
    public function findByIds(int|string ...$ids): iterable
    {
        return array_filter($this->products, fn(ProductEntity $p) => in_array($p->id(), $ids));
    }

    /**
     * Returns the found entity using the specified where parameters
     * or null if none found.
     *
     * @param array $where
     * @return null|object
     * @throws RepositoryReadException
     */
    public function findOne(array $where = []): null|ProductEntity
    {
        $columnToMethod = [
            'id' => 'id',
            'sku' => 'sku',
            'price' => 'price',
        ];
        
        $filtered = $this->products;
        
        foreach($where as $column => $value) {
            
            if (!isset($columnToMethod[$column])) {
                continue;
            }
            
            $method = $columnToMethod[$column];
                
            $filtered = array_filter($filtered, fn(ProductEntity $p) => $p->$method() === $value);
        }
        
        return $filtered[array_key_first($filtered)] ?? null;
    }

    /**
     * Returns the found entities using the specified parameters.
     *
     * @param array $where Usually where parameters.
     * @param array $orderBy The order by parameters.
     * @param null|int|array $limit The limit e.g. 5 or [5(number), 10(offset)].
     * @return iterable<object>
     * @throws RepositoryReadException
     */
    public function findAll(array $where = [], array $orderBy = [], null|int|array $limit = null): iterable
    {
        return $this->products;
    }
}