<?php

/**
 * Representation base class
 * 
 * @package simplerest.http
 * @author  Emmanuel Bouton
 */
class Representation
{
    public function getContent()
    {
        ob_start();
        $this->write();
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    protected function write() {}
}

