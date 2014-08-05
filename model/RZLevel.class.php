<?php

class RZLevel
{
    public function __Construct()
    {
    }

    public $id;
    public $title;

    public function fromXmlNode($node)
    {
        $this->id = $node->id;
        $this->title = $node->title;
    }
}
