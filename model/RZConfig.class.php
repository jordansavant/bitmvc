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
}
