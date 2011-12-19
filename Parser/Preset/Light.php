<?php

namespace WEBMI\Bundle\Text2ImageBundle\Parser\Preset;

use WEBMI\Bundle\Text2ImageBundle\Parser\Text2ImageParser;

/**
 * Light featured Text2Image Parser
 */
class Light extends Text2ImageParser
{

    protected $features = array(
        'header' => true,
        'list' => true,
        'horizontal_rule' => true,
        'table' => false,
        'foot_note' => false,
        'fenced_code_block' => false,
        'abbreviation' => false,
        'definition_list' => false,
        'inline_link' => true, // [link text](url "optional title")
        'reference_link' => true, // [link text] [id]
        'shortcut_link' => false, // [link text]
        'html_block' => false,
        'block_quote' => false,
        'code_block' => false,
        'auto_link' => true,
        'auto_mailto' => false,
        'entities' => false
    );

}
