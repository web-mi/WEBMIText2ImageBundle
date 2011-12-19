<?php

namespace WEBMI\Bundle\Text2ImageBundle\Parser\Preset;

use WEBMI\Bundle\Text2ImageBundle\Parser\Text2ImageParser;

/**
 * Minimally featured Text2Image Parser
 */
class Min extends Text2ImageParser
{

    public function __construct(array $features = array())
    {
        foreach ($this->features as $name => $enabled) {
            $this->features[$name] = false;
        }

        return parent::__construct($features);
    }

}

