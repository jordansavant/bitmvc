<?php

class RZLevel extends RZBase
{
    # properties
    public $id;
    public $title;
    public $rows;
    public $columns;
    public $tileMap;
    public $structureMap;
    public $characterMap;

    # collections
    public $tiles;
    public $structures;
    public $characters;
    public $lights;

    public function getNodeName()
    {
        return 'level';
    }

    public function canForm($field)
    {
        return in_array($field, array('title', 'rows', 'columns'));
    }

    public function create($id)
    {
        # Validate
        if(!$this->title)
        {
            throw new Exception("Title is required");
        }

        if(!$this->validateUnsignedInt($this->rows) || !$this->validateUnsignedInt($this->columns))
        {
            throw new Exception("Rows and columns must be a positive number");
        }

        $this->id = $id;

        # create maps
        $this->tileMap = $this->buildEmptyMap($this->rows, $this->columns);
        $this->structureMap = $this->buildEmptyMap($this->rows, $this->columns);
        $this->characterMap = $this->buildEmptyMap($this->rows, $this->columns);
    }

    private function buildEmptyMap($rows, $columns)
    {
        $s = str_repeat('0,', $rows * $columns);
        return substr($s, 0, -1);
    }
}
