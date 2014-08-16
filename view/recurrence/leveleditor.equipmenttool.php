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
    echo '<input name="equipment[slots][]" type="hidden" value="'.$slot.'" /><label class="formLabel">'.$v.'</label>';
    echo RZConfig::buildItemDD('equipment[items][]', $type);
    echo '<br>';
}
?>
</div>
</div>
