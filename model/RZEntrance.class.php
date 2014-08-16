<?php

class RZEntrance extends RZBase
{
    public function __construct()
    {
        $this->priority = '0';
    }

    # properties
    public $id;
    public $priority;

    public function getNodeName()
    {
        return 'entrance';
    }

    public function create()
    {
        $this->validate();
    }

    public function edit()
    {
        $this->validate();
    }

    public function validate()
    {
        if(!$this->validateUnsignedInt($this->id))
            throw new Exception("ID must be a positive number");

        if(!$this->validateUnsignedInt($this->priority, false))
            throw new Exception("Priority must be an unsigned int");
    }
}

