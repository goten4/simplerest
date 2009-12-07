<?php

/**
 * Implementation for a string representation
 * 
 * @package simplerest.representation
 * @author  Emmanuel Bouton
 */
class StringRepresentation extends Representation
{
    protected $_input;

    /**
     * Constructor
     * 
     * @param string $input The input string
     * @return void
     */
    public function __construct($input)
    {
        $this->_input = $input;
    }
    
	public function getInput()
	{
	    return $this->_input;
	}

	public function setInput($input)
	{
	    $this->_input = $input;
	}

    protected function write()
    {
        echo $this->_input;
    }
}

