<?php

class RZLevel extends RZBase
{
    public function __Construct()
    {
    }

    public $id;
    public $title;
    public $rows;
    public $columns;

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

        if(!$this->validateUnsignedInt($this->rows) || !$this->validateUnsignedInt($this->columns))
        {
            throw new Exception("Rows and columns must be a positive number");
        }
    }
}
