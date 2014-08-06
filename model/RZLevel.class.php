<?php

class RZLevel extends RZBase
{
    public function __Construct()
    {
    }

    public $id;
    public $title;

    public function getNodeName()
    {
        return 'level';
    }

    public function create()
    {
        # Validate
        if(!$this->title || !$this->id)
        {
            throw new Exception("Title and ID is required");
        }
    }
}
