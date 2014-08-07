<?php

class RZTile extends RZBase
{
    # properties
    public $id;
    public $type;

    public function getNodeName()
    {
        return 'tile';
    }

    public function canForm($field)
    {
        return in_array($field, array('type'));
    }

    public function create($id)
    {
        $this->validate();
        $this->id = $id;
    }

    public function edit()
    {
        $this->validate();
    }

    public function validate()
    {
        if(!$this->validateUnsignedInt($this->type))
        {
            throw new Exception("Type  must be a positive number");
        }
    }
}

