<?php

class RZLevel extends RZBase
{
    public function __construct()
    {
        $this->tiles = $this->structures = $this->characters = $this->lights = array();
    }

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

    public function fromXmlNode($node)
    {
        $this->id = (string)$node->id;
        $this->title = (string)$node->title;
        $this->rows = (string)$node->rows;
        $this->columns = (string)$node->columns;
        $this->tileMap = (string)$node->tileMap;
        $this->structureMap = (string)$node->structureMap;
        $this->characterMape = (string)$node->characterMap;

        foreach($node->tiles as $tiles)
        {
            foreach($tiles as $tile)
            {
                $rzTile = new RZTile();
                $rzTile->fromXmlNode($tile);
                $this->tiles[] = $rzTile;
            }
        }

        foreach($node->structures as $structures)
        {
            foreach($structures as $structure)
            {
                $rzStructure = new RZStructure();
                $rzStructure->fromXmlNode($structure);
                $this->structures[] = $rzStructure;
            }
        }
    }

    public function canForm($field)
    {
        return in_array($field, array('title', 'rows', 'columns'));
    }

    public function getTileByIndex($index)
    {
        $tileMap = explode(',', $this->tileMap);
        $tileId = $tileMap[$index];

        return $this->getTileById($tileId);
    }

    public function getTileById($id)
    {
        if(is_array($this->tiles))
        {
            foreach($this->tiles as $rzTile)
            {
                if($rzTile->id == $id)
                    return $rzTile;
            }
        }
        return null;
    }

    public function getStructureByIndex($index)
    {
        $structureMap = explode(',', $this->structureMap);
        $structureId = $structureMap[$index];

        return $this->getStructureById($structureId);
    }

    public function getStructureById($id)
    {
        if(is_array($this->structures))
        {
            foreach($this->structures as $rzStructure)
            {
                if($rzStructure->id == $id)
                    return $rzStructure;
            }
        }
        return null;
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

        # prepopulate tiles
        for($i=0; $i < $this->rows; $i++)
        {
            for($j=0; $j < $this->columns; $j++)
            {
                $index = $i * $this->rows + $j;
                $rzTile = new RZTile();
                $rzTile->type = RZConfig::getDefaultTileType();
                $rzTile->id = $index + 1;
                $this->addTileAtIndex($rzTile, $index);
            }
        }
    }

    private function buildEmptyMap($rows, $columns)
    {
        $s = str_repeat('0,', $rows * $columns);
        return substr($s, 0, -1);
    }

    public function addTileAtIndex($rzTile, $index)
    {
        # Set the tile
        if(!is_array($this->tiles))
        {
            $this->tiles = array();
        }
        $this->tiles[] = $rzTile;

        # Write its id to the position map
        $tilemap = explode(',', $this->tileMap);
        $tilemap[$index] = $rzTile->id;
        $this->tileMap = implode(',', $tilemap);
    }

    public function addStructureAtIndex($rzStructure, $index)
    {
        # Set the structure
        if(!is_array($this->structures))
        {
            $this->structures = array();
        }
        $this->structures[] = $rzStructure;

        # Write its id to the position map
        $structuremap = explode(',', $this->structureMap);
        $structuremap[$index] = $rzStructure->id;
        $this->structureMap = implode(',', $structuremap);
    }
}
