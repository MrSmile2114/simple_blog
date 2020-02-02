<?php

class HTMLPurifier_HTMLModule_Tidy_XHTML extends HTMLPurifier_HTMLModule_Tidy
{
    /**
     * @var string
     */
    public $name = 'Tidy_XHTML';

    /**
     * @var string
     */
    public $defaultLevel = 'medium';

    /**
     * @return array
     */
    public function makeFixes()
    {
        $r = [];
        $r['@lang'] = new HTMLPurifier_AttrTransform_Lang();

        return $r;
    }
}

// vim: et sw=4 sts=4
