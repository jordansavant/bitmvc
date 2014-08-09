<div id="itemtool">
<script>
var i=0;
function buildItem(index, dd, slot, pos)
{
    return '<div id="item'+ index +'"> slot:<input type="text" style="width: 20px" name="itemtool[item_slots][]" value="'+slot+'" /> pos:<input type="text" style="width: 20px" name="itemtool[item_poss][]"" value="'+pos+'" /> '+dd+' <a href="javascript: removeItem('+ index +');">X</a></div>'
}
function addItem()
{
    $('#items').append(buildItem(i, '<?php echo RZConfig::buildItemDD('itemtool[items][]');?>', 0, 0));
    i++;
}
function removeItem(index)
{
    $('#item'+index).remove();
}
</script>
<div id="items"></div>
<?php
$i=0;
foreach($args['items'] as $rzItem)
{
    echo "<script> $('#items').append(buildItem($i, '". RZConfig::buildItemDD('itemtool[items][]', $rzItem->type) ."', ".$rzItem->slot.", ".$rzItem->position.")); </script>";
    $i++;
}
?>
<a href="javascript: addItem();">Add Item</a>
<script>i=<?=$i+1;?>;</script>
</div>
