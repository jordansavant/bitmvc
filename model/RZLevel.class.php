<?php

class RZLevel extends RZBase
{
    public function __construct()
    {
        $this->tiles = $this->structures = $this->characters = $this->lights = array();
        $this->defaultEntranceId = '0';
    }

    # properties
    public $id;
    public $title;
    public $rows;
    public $columns;
    public $defaultEntranceId;
    public $tileMap;
    public $structureMap;
    public $characterMap;
    public $lightMap;

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
        $this->characterMap = (string)$node->characterMap;
        $this->lightMap = (string)$node->lightMap;

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

        foreach($node->characters as $characters)
        {
            foreach($characters as $character)
            {
                $rzCharacter = new RZCharacter();
                $rzCharacter->fromXmlNode($character);
                $this->characters[] = $rzCharacter;
            }
        }

        foreach($node->lights as $lights)
        {
            foreach($lights as $light)
            {
                $rzLight = new RZLight();
                $rzLight->fromXmlNode($light);
                $this->lights[] = $rzLight;
            }
        }
    }

    public function canForm($field)
    {
        return in_array($field, array('title', 'rows', 'columns', 'defaultEntranceId'));
    }

    /**
     * Tile management
     */
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

    /**
     * Structure management
     */
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

    public function deleteStructureById($id)
    {
        if(is_array($this->structures))
        {
            $i=0;
            foreach($this->structures as $rzStructure)
            {
                if($rzStructure->id == $id)
                {
                    $this->structureMap = $this->clearIdFromMap($this->structureMap, $id);
                    unset($this->structures[$i]);
                }
                $i++;
            }
        }
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

    public function getNextStructureId()
    {
        $newId = 1;
        foreach($this->structures as $rzStructure)
        {
            $newId = max($newId, $rzStructure->id + 1);
        }
        return $newId;
    }

    /**
     * Character management
     */
    public function getCharacterByIndex($index)
    {
        $characterMap = explode(',', $this->characterMap);
        $characterId = $characterMap[$index];

        return $this->getCharacterById($characterId);
    }

    public function getCharacterById($id)
    {
        if(is_array($this->characters))
        {
            foreach($this->characters as $rzCharacter)
            {
                if($rzCharacter->id == $id)
                    return $rzCharacter;
            }
        }
        return null;
    }

    public function deleteCharacterById($id)
    {
        if(is_array($this->characters))
        {
            $i=0;
            foreach($this->characters as $rzCharacter)
            {
                if($rzCharacter->id == $id)
                {
                    $this->characterMap = $this->clearIdFromMap($this->characterMap, $id);
                    unset($this->characters[$i]);
                }
                $i++;
            }
        }
    }

    public function addCharacterAtIndex($rzCharacter, $index)
    {
        # Set the character
        if(!is_array($this->characters))
        {
            $this->characters = array();
        }
        $this->characters[] = $rzCharacter;

        # Write its id to the position map
        $charactermap = explode(',', $this->characterMap);
        $charactermap[$index] = $rzCharacter->id;
        $this->characterMap = implode(',', $charactermap);
    }

    public function getNextCharacterId()
    {
        $newId = 1;
        foreach($this->characters as $rzCharacter)
        {
            $newId = max($newId, $rzCharacter->id + 1);
        }
        return $newId;
    }


    /**
     * Light management
     */
    public function getLightByIndex($index)
    {
        $lightMap = explode(',', $this->lightMap);
        $lightId = $lightMap[$index];

        return $this->getLightById($lightId);
    }

    public function getLightById($id)
    {
        if(is_array($this->lights))
        {
            foreach($this->lights as $rzLight)
            {
                if($rzLight->id == $id)
                    return $rzLight;
            }
        }
        return null;
    }

    public function deleteLightById($id)
    {
        if(is_array($this->lights))
        {
            $i=0;
            foreach($this->lights as $rzLight)
            {
                if($rzLight->id == $id)
                {
                    $this->lightMap = $this->clearIdFromMap($this->lightMap, $id);
                    unset($this->lights[$i]);
                }
                $i++;
            }
        }
    }

    public function addLightAtIndex($rzLight, $index)
    {
        # Set the light
        if(!is_array($this->lights))
        {
            $this->lights = array();
        }
        $this->lights[] = $rzLight;

        # Write its id to the position map
        $lightmap = explode(',', $this->lightMap);
        $lightmap[$index] = $rzLight->id;
        $this->lightMap = implode(',', $lightmap);
    }

    public function getNextLightId()
    {
        $newId = 1;
        foreach($this->lights as $rzLight)
        {
            $newId = max($newId, $rzLight->id + 1);
        }
        return $newId;
    }




    public function create($id)
    {
        $this->validate();
        $this->id = $id;

        # create maps
        $this->tileMap = $this->buildEmptyMap($this->rows, $this->columns);
        $this->structureMap = $this->buildEmptyMap($this->rows, $this->columns);
        $this->characterMap = $this->buildEmptyMap($this->rows, $this->columns);
        $this->lightMap = $this->buildEmptyMap($this->rows, $this->columns);

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

    public function edit()
    {
        $this->validate();
    }

    private function validate()
    {
        # Validate
        if(!$this->title)
            throw new Exception("Title is required");

        if(!$this->validateUnsignedInt($this->rows) || !$this->validateUnsignedInt($this->columns))
            throw new Exception("Rows and columns must be a positive number");

        if(!$this->validateUnsignedInt($this->defaultEntranceId, false))
            throw new Exception("Default entrance id must be an unsigned int");
    }

    private function buildEmptyMap($rows, $columns)
    {
        $s = str_repeat('0,', $rows * $columns);
        return substr($s, 0, -1);
    }

    private function getIdAtIndex($map, $index)
    {
        $map = explode(',', $this->map);
        return $map[$index];
    }

    private function setIdAtIndex($map, $index, $id)
    {
        $map = explode(',', $map);
        $map[$index] = $id;
        return implode(',', $map);
    }

    private function clearIdFromMap($map, $id, $default = '0')
    {
        $map = explode(',', $map);
        foreach($map as $i => $di)
        {
            if($id == $di)
                $map[$i] = $default;
        }
        return implode(',', $map);
    }
}
