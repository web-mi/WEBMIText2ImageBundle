<?php

namespace WEBMI\Bundle\Text2ImageBundle\Twig\Extension;

use WEBMI\Bundle\Text2ImageBundle\Helper\Text2ImageHelper;

class Text2ImageTwigExtension extends \Twig_Extension
{
    protected $helper;

    function __construct(Text2ImageHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getFilters()
    {
        return array(
            'text2image' => new \Twig_Filter_Method($this, 'text2image', array('is_safe' => array('html'))),
        );
    }

    public function text2image($txt)
    {
        return $this->helper->transform($txt);
    }

    public function getName()
    {
        return 'text2image';
    }
}
