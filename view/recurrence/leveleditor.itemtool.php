<script>
var i=0;
function buildItem(index, dd, slot)
{
    return '<div id="item'+ index +'"> slot:<input type="text" style="width: 20px" name="itemtool[item_slots][]" value="'+slot+'" /> '+dd+' <a href="javascript: removeItem('+ index +');">X</a></div>'
}
function addItem()
{
    $('#items').append(buildItem(i, '<?php echo RZConfig::buildItemDD('itemtool[items][]');?>', 0));
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
    echo "<script> $('#items').append(buildItem($i, '". RZConfig::buildItemDD('itemtool[items][]', $rzItem->type) ."', ".$rzItem->slot.")); </script>";
    $i++;
}
?>
<a href="javascript: addItem();">Add Item</a>
<script>i=<?=$i+1;?>;</script>
