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
use Tobento\Service\Repository\RepositoryUpdateException;
use Tobento\Service\Repository\RepositoryException;

/**
 * RepositoryUpdateExceptionTest
 */
class RepositoryUpdateExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new RepositoryUpdateException(message: 'Message');
        
        $this->assertInstanceof(RepositoryException::class, $e);
        $this->assertSame('Message', $e->getMessage());
        $this->assertSame([], $e->attributes());
        $this->assertSame('', $e->id());
    }
    
    public function testWithAttributesAndId()
    {
        $e = new RepositoryUpdateException(attributes: ['key' => 'value'], id: 2);
        
        $this->assertSame(['key' => 'value'], $e->attributes());
        $this->assertSame(2, $e->id());
    }
}