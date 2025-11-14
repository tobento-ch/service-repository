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

trait HasLocales
{
    /**
     * @var string
     */
    protected string $locale = 'en';
    
    /**
     * @var array<int, string>
     */
    protected array $locales = ['en'];
    
    /**
     * @var array<string, string>
     */
    protected array $localeFallbacks = [];
    
    /**
     * Sets the locale.
     *
     * @param string $locale
     * @return static $this
     */
    public function locale(string $locale): static
    {
        $this->locale = $locale;
        return $this;
    }
    
    /**
     * Sets the locale returing a new instance.
     *
     * @param string $locale
     * @return static
     */
    public function withLocale(string $locale): static
    {
        $new = clone $this;
        $new->locale($locale);
        return $new;
    }
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }
    
    /**
     * Sets the locales.
     *
     * @param string ...$locales
     * @return static $this
     */
    public function locales(string ...$locales): static
    {
        $this->locales = $locales;
        return $this;
    }
    
    /**
     * Sets the locales returning a new instance.
     *
     * @param string ...$locales
     * @return static
     */
    public function withLocales(string ...$locales): static
    {
        $new = clone $this;
        $new->locales(...$locales);
        return $new;
    }
    
    /**
     * Returns the locales.
     *
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }
    
    /**
     * Sets the locale fallbacks.
     *
     * @param array<string, string> $localeFallbacks
     * @return static $this
     */
    public function localeFallbacks(array $localeFallbacks): static
    {
        $this->localeFallbacks = $localeFallbacks;
        return $this;
    }
    
    /**
     * Sets the locale fallbacks returning a new instance.
     *
     * @param array<string, string> $localeFallbacks
     * @return static
     */
    public function withLocaleFallbacks(array $localeFallbacks): static
    {
        $new = clone $this;
        $new->localeFallbacks($localeFallbacks);
        return $new;
    }
    
    /**
     * Returns the locale fallbacks.
     *
     * @return array<string, string>
     */
    public function getLocaleFallbacks(): array
    {
        return $this->localeFallbacks;
    }
}