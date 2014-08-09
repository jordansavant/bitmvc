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
            '1' => 'Hardhat',
            '2' => 'Magnum',
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

    public static function getTiles()
    {
        return array(
            '1' => 'Concrete',
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
        foreach(self::getStructures() as $strucutreType => $strucutreLabel)
        {
            $x = $selected == $strucutreType ? 'selected="selected"' : '';
            $s .= '<option value="'.$strucutreType.'" '.$x.'>'.$strucutreLabel.'</option>';
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
