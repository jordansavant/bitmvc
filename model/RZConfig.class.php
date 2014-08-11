<?php
class RZConfig
{
    public static function getVersion()
    {
        return "1";
    }

    public static function getDataDirectory()
    {
        return dirname(__FILE__)."/../data/";
    }

    public static function getDefaultTileType()
    {
        return 1;
    }

    public static function getItems()
    {
        return array(
            '1' => 'Backpack',
            '2' => 'Hardhat',
            '3' => '357 Magnum',
            '4' => 'Z4 Rifle',
            '5' => 'Crowbar',
        );
    }

    public static function getStructures()
    {
        return array(
            '1' => 'Wall',
            '2' => 'Door',
            '3' => 'Chest',
        );
    }

    public static function getCharacters()
    {
        return array(
            '1' => 'Zombie',
            '2' => 'Ogre',
            '3' => 'Hunter',
        );
    }

    public static function getTiles()
    {
        return array(
            '1' => 'Ground',
            '2' => 'Spawn',
        );
    }

    public static function buildItemDD($name, $selected = null)
    {
        $s = '<select name="'.$name.'">';
        foreach(self::getItems() as $itemType => $itemLabel)
        {
            $x = $selected == $itemType ? 'selected="selected"' : '';
            $s .= '<option value="'.$itemType.'" '.$x.'>'.$itemLabel.'</option>';
        }
        $s .= '</select>';

        return $s;
    }

    public static function buildStructureDD($name, $selected = null)
    {
        $s = '<select name="'.$name.'">';
        foreach(self::getStructures() as $structureType => $structureLabel)
        {
            $x = $selected == $structureType ? 'selected="selected"' : '';
            $s .= '<option value="'.$structureType.'" '.$x.'>'.$structureLabel.'</option>';
        }
        $s .= '</select>';

        return $s;
    }

    public static function buildCharacterDD($name, $selected = null)
    {
        $s = '<select name="'.$name.'">';
        foreach(self::getCharacters() as $characterType => $characterLabel)
        {
            $x = $selected == $characterType ? 'selected="selected"' : '';
            $s .= '<option value="'.$characterType.'" '.$x.'>'.$characterLabel.'</option>';
        }
        $s .= '</select>';

        return $s;
    }

    public static function buildTileDD($name, $selected = null)
    {
        $s = '<select name="'.$name.'">';
        foreach(self::getTiles() as $tileType => $tileLabel)
        {
            $x = $selected == $tileType ? 'selected="selected"' : '';
            $s .= '<option value="'.$tileType.'" '.$x.'>'.$tileLabel.'</option>';
        }
        $s .= '</select>';

        return $s;
    }
}
