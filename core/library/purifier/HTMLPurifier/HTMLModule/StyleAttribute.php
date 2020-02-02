<?php

/**
 * XHTML 1.1 Edit Module, defines editing-related elements. Text Extension
 * Module.
 */
class HTMLPurifier_HTMLModule_StyleAttribute extends HTMLPurifier_HTMLModule
{
    /**
     * @var string
     */
    public $name = 'StyleAttribute';

    /**
     * @var array
     */
    public $attr_collections = [
        // The inclusion routine differs from the Abstract Modules but
        // is in line with the DTD and XML Schemas.
        'Style' => ['style' => false], // see constructor
        'Core'  => [0 => ['Style']],
    ];

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $this->attr_collections['Style']['style'] = new HTMLPurifier_AttrDef_CSS();
    }
}

// vim: et sw=4 sts=4
