<?php

class RZItem extends RZBase
{
    public function __construct()
    {
        $this->position = '0';
    }

    # properties
    public $id;
    public $type;
    public $slot;
    public $position;

    public function getNodeName()
    {
        return 'item';
    }

    public function canForm($field)
    {
        return in_array($field, array('type', 'slot', 'position'));
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
            throw new Exception("Type must be a positive number");

        if(!$this->validateUnsignedInt($this->position, false))
            throw new Exception("Position must be a positive number");
    }
}

