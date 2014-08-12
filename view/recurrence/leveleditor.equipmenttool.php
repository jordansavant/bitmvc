<div id="equipmenttool">
<div id="equipment">
<?php
foreach(RZConfig::getEquipmentSlots() as $k => $v)
{
    $slot = $k;
    $type = '';
    foreach($args['equipment'] as $rzItem)
    {
        if($rzItem->slot == $k)
        {
            $slot = $k;
            $type = $rzItem->type;
        }
    }
    echo RZConfig::buildEquipmentSlotDD('equipment[slots][]', $slot);
    echo RZConfig::buildItemDD('equipment[items][]', $type);
    echo '<br>';
}
?>
</div>
</div>
