<?php

namespace WEBMI\Bundle\Text2ImageBundle\Parser\Preset;

use WEBMI\Bundle\Text2ImageBundle\Parser\Text2ImageParser;
/**
 * Medium featured Text2Image Parser
 */
class Medium extends Text2ImageParser
{

    protected $features = array(
        'header' => true,
        'list' => true,
        'horizontal_rule' => true,
        'table' => false,
        'foot_note' => true,
        'fenced_code_block' => true,
        'abbreviation' => true,
        'definition_list' => false,
        'inline_link' => true, // [link text](url "optional title")
        'reference_link' => true, // [link text] [id]
        'shortcut_link' => true, // [link text]
        'html_block' => false,
        'block_quote' => false,
        'code_block' => true,
        'auto_link' => true,
        'auto_mailto' => false,
        'entities' => false
    );

}
