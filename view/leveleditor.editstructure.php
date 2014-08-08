<script>
var i=0;
function buildItem(index, dd, slot)
{
    return '<div id="item'+ index +'"> slot:<input type="text" style="width: 20px" name="RZStructure[item_slots][]" value="'+slot+'" /> '+dd+' <a href="javascript: removeItem('+ index +');">X</a></div>'
}
function addItem()
{
    $('#items').append(buildItem(i, '<?php echo RZConfig::buildItemDD('RZStructure[items][]');?>', 0));
    i++;
}
function removeItem(index)
{
    $('#item'+index).remove();
}
</script>

##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
 &gt; <a href="index.php?c=<?=$C?>&o=editLevel&lp=<?=$this->lp?>&lid=<?=$this->lid?>">Level</a>
##end##

<h1>Edit Structure</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=editStructure&lp=<?=$this->lp?>&lid=<?=$this->lid?>&sid=<?=$this->sid?>" method="post">
<?php
echo $this->rzStructure->toForm();
?>
<br>
<div id="items">
</div>
<?php
$i=0;
foreach($this->rzStructure->items as $rzItem)
{
    echo "<script> $('#items').append(buildItem($i, '". RZConfig::buildItemDD('RZStructure[items][]', $rzItem->type) ."', ".$rzItem->slot.")); </script>";
    $i++;
}
?>
<script>
i=<?=$i+1;?>;
</script>
<a href="javascript: addItem();">Add Item</a>
<br>
<br>
<input type="submit" value="Save Structure" />
</form>
