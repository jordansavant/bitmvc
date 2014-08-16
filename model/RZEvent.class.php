<?php

class RZEvent extends RZBase
{
    public function __construct()
    {
        $this->targetLevelId = $this->targetEntranceId = '0';
    }

    # properties
    public $type;
    public $targetLevelId;
    public $targetEntranceId;

    public function getNodeName()
    {
        return 'event';
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
            throw new Exception("Type must be a positive number");
        }

        if(!$this->validateUnsignedInt($this->targetLevelId, false))
        {
            throw new Exception("Target Level Id must be an unsigned int");
        }

        if(!$this->validateUnsignedInt($this->targetEntranceId, false))
        {
            throw new Exception("Target Entrance Id must be an unsigned int");
        }
    }
}

