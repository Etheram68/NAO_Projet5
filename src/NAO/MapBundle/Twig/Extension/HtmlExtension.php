<?php

namespace NAO\MapBundle\Twig\Extension;
/**
 * Class HtmlExtension.
 */
class HtmlExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('html', [$this, 'html'], ['is_safe' => ['html']]),
        ];
    }
    public function html($html)
    {
        return $html;
    }
    public function getName()
    {
        return 'html_extension';
    }
}