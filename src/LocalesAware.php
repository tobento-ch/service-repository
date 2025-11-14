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

namespace Tobento\Service\Repository;

interface LocalesAware
{
    /**
     * Sets the locale.
     *
     * @param string $locale
     * @return static $this
     */
    public function locale(string $locale): static;
    
    /**
     * Sets the locale returing a new instance.
     *
     * @param string $locale
     * @return static
     */
    public function withLocale(string $locale): static;
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function getLocale(): string;
    
    /**
     * Sets the locales.
     *
     * @param string ...$locales
     * @return static $this
     */
    public function locales(string ...$locales): static;
    
    /**
     * Sets the locales returning a new instance.
     *
     * @param string ...$locales
     * @return static
     */
    public function withLocales(string ...$locales): static;
    
    /**
     * Returns the locales.
     *
     * @return array
     */
    public function getLocales(): array;
    
    /**
     * Sets the locale fallbacks.
     *
     * @param array<string, string> $localeFallbacks
     * @return static $this
     */
    public function localeFallbacks(array $localeFallbacks): static;
    
    /**
     * Sets the locale fallbacks returning a new instance.
     *
     * @param array<string, string> $localeFallbacks
     * @return static
     */
    public function withLocaleFallbacks(array $localeFallbacks): static;
    
    /**
     * Returns the locale fallbacks.
     *
     * @return array<string, string>
     */
    public function getLocaleFallbacks(): array;
}