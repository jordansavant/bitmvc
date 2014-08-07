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
}
