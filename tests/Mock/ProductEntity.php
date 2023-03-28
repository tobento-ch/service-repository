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

class ProductEntity
{
    public function __construct(
        protected int $id,
        protected string $sku,
        protected float $price,
    ) {}
    
    public function id(): int
    {
        return $this->id;
    }
    
    public function sku(): string
    {
        return $this->sku;
    }
    
    public function price(): float
    {
        return $this->price;
    }
}