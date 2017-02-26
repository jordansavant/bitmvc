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
            '0' => '--',
            '1' => 'Backpack',
            '2' => 'Hardhat',
            '3' => 'Magnum',
            '4' => 'Z4 Rifle',
            '5' => 'Crowbar',
            '6' => 'Medkit',
            '7' => 'Brick',
            '8' => 'Grenade',
            '9' => 'FootballPads',
            '10' => 'CombatBoots',
            '11' => 'RacingPants',
            '12' => 'CleaningGloves',
            '13' => 'GoldMedal',
        );
    }

    public static function getEquipmentSlots()
    {
        return array(
            '0' => 'Head',
            '1' => 'Chest',
            '2' => 'Legs',
            '3' => 'Feet',
            '4' => 'Hands',
            '5' => 'Totem',
            '6' => 'WeaponPrimary',
            '7' => 'WeaponSecondary',
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
            '2' => 'StairwellDown_South',
            '3' => 'StairwellDown_East',
            '4' => 'StairwellUp_North',
            '5' => 'StairwellUp_West',
            '6' => 'StairwellDown_North',
            '7' => 'StairwellDown_West',
            '8' => 'StairwellUp_South',
            '9' => 'StairwellUp_East',
        );
    }

    public static function getEvents()
    {
        return array(
            '1' => 'Player GoToLevel',
            '2' => 'NPC GoToLevel',
            '3' => 'GameVictory',
            '4' => 'GameDefeat',
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

    protected static function buildDD($elements, $name, $selected = null, $supportsBlank = false)
    {
        $s = '<select name="'.$name.'">';
        $s .= $supportsBlank ? '<option value="">--</option>' : '';
        foreach($elements as $key => $value)
        {
            $x = (string)$selected == (string)$key ? 'selected="selected"' : '';
            $s .= '<option value="'.$key.'" '.$x.'>'.$value.'</option>';
        }
        $s .= '</select>';
        return $s;
    }

    public static function buildEquipmentSlotDD($name, $selected = null)
    {
        return self::buildDD(self::getEquipmentSlots(), $name, $selected, true);
    }

    public static function buildStructureDD($name, $selected = null)
    {
        return self::buildDD(self::getStructures(), $name, $selected);
    }

    public static function buildCharacterDD($name, $selected = null)
    {
        return self::buildDD(self::getCharacters(), $name, $selected);
    }

    public static function buildTileDD($name, $selected = null)
    {
        return self::buildDD(self::getTiles(), $name, $selected);
    }

    public static function buildEventDD($name, $selected = null)
    {
        return self::buildDD(self::getEvents(), $name, $selected);
    }

}
