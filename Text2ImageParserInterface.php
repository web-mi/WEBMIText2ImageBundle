<?php

namespace WEBMI\Bundle\Text2ImageBundle;

interface Text2ImageParserInterface
{
    /**
     * Converts text to image using text2image rules
     *
     * @param string $text plain text
     * @return string rendered html
     */
    function transform($text);
}
