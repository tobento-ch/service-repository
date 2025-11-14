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

class RepositoryLocalesAwareTest extends TestCase
{
    public function testLocaleMethod()
    {
        $repo = new Mock\ProductRepository();
                
        $this->assertSame('en', $repo->getLocale());
        
        $repo->locale('de');
        
        $this->assertSame('de', $repo->getLocale());
    }
    
    public function testWithLocaleMethod()
    {
        $repo = new Mock\ProductRepository();

        $repoNew = $repo->withLocale('de');
        
        $this->assertFalse($repo === $repoNew);
        $this->assertSame('en', $repo->getLocale());
        $this->assertSame('de', $repoNew->getLocale());
    }
    
    public function testLocalesMethod()
    {
        $repo = new Mock\ProductRepository();
                
        $this->assertSame(['en'], $repo->getLocales());
        
        $repo->locales('fr', 'de');
        
        $this->assertSame(['fr', 'de'], $repo->getLocales());
    }
    
    public function testWithLocalesMethod()
    {
        $repo = new Mock\ProductRepository();

        $repoNew = $repo->withLocales('fr', 'de');
        
        $this->assertFalse($repo === $repoNew);
        $this->assertSame(['en'], $repo->getLocales());
        $this->assertSame(['fr', 'de'], $repoNew->getLocales());
    }
    
    public function testLocaleFallbacksMethod()
    {
        $repo = new Mock\ProductRepository();
                
        $this->assertSame([], $repo->getLocaleFallbacks());
        
        $repo->localeFallbacks(['de' => 'en']);
        
        $this->assertSame(['de' => 'en'], $repo->getLocaleFallbacks());
    }
    
    public function testWithLocaleFallbacksMethod()
    {
        $repo = new Mock\ProductRepository();

        $repoNew = $repo->withLocaleFallbacks(['de' => 'en']);
        
        $this->assertFalse($repo === $repoNew);
        $this->assertSame([], $repo->getLocaleFallbacks());
        $this->assertSame(['de' => 'en'], $repoNew->getLocaleFallbacks());
    }
}