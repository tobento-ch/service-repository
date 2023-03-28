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

use Tobento\Service\Repository\WriteRepositoryInterface;
use Tobento\Service\Repository\RepositoryCreateException;
use Tobento\Service\Repository\RepositoryUpdateException;
use Tobento\Service\Repository\RepositoryDeleteException;

/**
 * Write methods, just for testing purposes.
 */
trait ProductWriteMethods
{
    /**
     * Create an entity.
     *
     * @param array $attributes
     * @return object The created entity.
     * @throws RepositoryCreateException
     */
    public function create(array $attributes): ProductEntity
    {
        return new ProductEntity(
            id: $attributes['id'] ?? 0,
            sku: $attributes['sku'] ?? '',
            price: $attributes['price'] ?? 0,
        );
    }
    
    /**
     * Update an entity by id.
     *
     * @param string|int $id
     * @param array $attributes The attributes to update the entity.
     * @return object The updated entity.
     * @throws RepositoryUpdateException
     */
    public function updateById(string|int $id, array $attributes): ProductEntity
    {
        if (!array_key_exists($id, $this->products)) {
            throw new RepositoryUpdateException();
        }
        
        $entity = $this->products[$id];
        
        return $this->products[$id] = new ProductEntity(
            id: $entity->id(),
            sku: $attributes['sku'] ?? $entity->sku(),
            price: $attributes['price'] ?? $entity->price(),
        );
    }
    
    /**
     * Update entities.
     *
     * @param array $where The where parameters.
     * @param array $attributes The attributes to update the entities.
     * @return iterable<object> The updated entities.
     * @throws RepositoryUpdateException
     */
    public function update(array $where, array $attributes): iterable
    {
        $products = $this->filterWhere($this->products, $where);
        
        $updated = [];
        
        foreach($products as $i => $product) {
            $updated[$i] = new ProductEntity(
                id: $product->id(),
                sku: $attributes['sku'] ?? $product->sku(),
                price: $attributes['price'] ?? $product->price(),
            );
            
            $this->products[$i] = $updated[$i];
        }
        
        return $updated;
    }
    
    /**
     * Delete an entity by id.
     *
     * @param string|int $id
     * @return object The deleted entity.
     * @throws RepositoryDeleteException
     */
    public function deleteById(string|int $id): ProductEntity
    {
        if (!array_key_exists($id, $this->products)) {
            throw new RepositoryDeleteException();
        }
        
        $entity = $this->products[$id];
        
        return $this->products[$id] = new ProductEntity(
            id: $entity->id(),
            sku: $attributes['sku'] ?? $entity->sku(),
            price: $attributes['price'] ?? $entity->price(),
        );
    }
    
    /**
     * Delete entities.
     *
     * @param array $where The where parameters.
     * @return iterable<object> The deleted entities.
     * @throws RepositoryDeleteException
     */
    public function delete(array $where): iterable
    {
        $products = $this->filterWhere($this->products, $where);
        
        $deleted = [];
        
        foreach($products as $i => $product) {
            $deleted[$i] = new ProductEntity(
                id: $product->id(),
                sku: $attributes['sku'] ?? $product->sku(),
                price: $attributes['price'] ?? $product->price(),
            );
            
            unset($this->products[$i]);
        }
        
        return $deleted;
    }
    
    protected function filterWhere(array $products, array $where = []): array
    {
        $columnToMethod = [
            'id' => 'id',
            'sku' => 'sku',
            'price' => 'price',
        ];
        
        foreach($where as $column => $value) {
            
            if (!isset($columnToMethod[$column])) {
                continue;
            }
            
            $method = $columnToMethod[$column];
                
            $products = array_filter($products, fn(ProductEntity $p) => $p->$method() === $value);
        }
        
        return $products;
    }    
}