<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('substring', [$this, 'subString']),
            new TwigFunction('html_entity_decode', [$this, 'html_entity_decode']),
        ];
    }

    public function subString($value)
    {
        return strlen($value) > 100 ? substr($value, 0, 100) . '...' : $value;
    }

    public function html_entity_decode($value)
    {
        return html_entity_decode($value);
    }
}
