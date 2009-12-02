<?php

/**
 * Implementation for a string representation
 * 
 * @package simplerest.representation
 * @author  Emmanuel Bouton
 */
class StringRepresentation extends Representation
{
    protected $_content;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct($content)
    {
        $this->_content = $content;
    }
    
    protected function write()
    {
        echo $this->_content;
    }
}

