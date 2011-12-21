<?php

namespace WEBMI\Bundle\Text2ImageBundle\Twig\Extension;

use WEBMI\Bundle\Text2ImageBundle\Helper\Text2ImageHelper;

class Text2ImageTwigExtension extends \Twig_Extension
{
     public function getFilters() {
        return array(
            'var_dump'   => new \Twig_Filter_Function('var_dump'),
            'highlight'  => new \Twig_Filter_Method($this, 'highlight'),
            'text2image'  => new \Twig_Filter_Method($this, 'highlight'),
        );
    }

    public function highlight($sentence, $expr) {
        return preg_replace('/(' . $expr . ')/', '<span style="color:red">\1</span>', $sentence);
    }
    
    public function text2image($sentence, $expr) {
        return preg_replace('/(' . $expr['i'] . ')/', '<span style="color:red">\1</span>', $sentence);
    }

    public function getName()
    {
        return 'my_twig_extension';
    }
}
