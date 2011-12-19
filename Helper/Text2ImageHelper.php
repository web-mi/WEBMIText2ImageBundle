<?php

namespace WEBMI\Bundle\Text2ImageBundle\Helper;

use Symfony\Component\Templating\Helper\HelperInterface;
use WEBMI\Bundle\Text2ImageBundle\Parser\Text2ImageParser;

class Text2ImageHelper implements HelperInterface
{
    /**
     * @var Text2ImageParser
     */
    protected $parser;
    protected $charset = 'UTF-8';

    public function __construct(Text2ImageParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Sets the default charset.
     *
     * @param string $charset The charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Gets the default charset.
     *
     * @return string The default charset
     */
    public function getCharset()
    {
        return $this->charset;
    }

    public function getName()
    {
        return 'text2image';
    }

    /**
     * Transforms text2image syntax to HTML
     * @param   string  $text2imageText   The text2image syntax text
     * @return  string                  The HTML code
     */
    public function transform($text2imageText)
    {
        return $this->parser->transform($text2imageText);
    }

}
