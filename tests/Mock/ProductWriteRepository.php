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

/**
 * Use just for testing.
 */
class ProductWriteRepository implements WriteRepositoryInterface
{
    use ProductWriteMethods;
    
    protected array $products = [];
    
    public function __construct(
        ProductEntity ...$products,
    ) {
        if (!empty($products)) {
            $this->products = $products;
            return;
        }
        
        $this->products = [
            1 => new ProductEntity(id: 1, sku: 'paper', price: 1.2),
            2 => new ProductEntity(id: 2, sku: 'pen', price: 1.8),
            3 => new ProductEntity(id: 3, sku: 'pencil', price: 1.5),
        ];
    }
}