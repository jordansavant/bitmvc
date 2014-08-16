<?php
$prefix = isset($args['prefix']) ? $args['prefix'] : '';
?>
    <div id="<?=$prefix?>eventtool">
<script>
var i=0;
function build<?=$prefix?>Event(index, dd, tli, tei)
{
    return '<div id="<?=$prefix?>event'+ index +'"> '+dd+' Level ID:<input type="text" class="sss" name="<?=$prefix?>eventtool[event_tli][]"" value="'+tli+'" /> Entrance ID:<input type="text" class="sss" name="<?=$prefix?>eventtool[event_tei][]"" value="'+tei+'" /> <a href="javascript: remove<?=$prefix?>Event('+ index +');">X</a></div>'
}
function add<?=$prefix?>Event()
{
    $('#<?=$prefix?>events').append(build<?=$prefix?>Event(i, '<?php echo RZConfig::buildEventDD($prefix.'eventtool[events][]');?>', 0, 0));
    i++;
}
function remove<?=$prefix?>Event(index)
{
    $('#<?=$prefix?>event'+index).remove();
}
</script>
    <div id="<?=$prefix?>events"></div>
<?php
$i=0;
foreach($args['events'] as $rzEvent)
{
    echo "<script>$('#${prefix}events').append(build${prefix}Event($i, '". RZConfig::buildEventDD($prefix.'eventtool[events][]', $rzEvent->type) ."', ".$rzEvent->targetLevelId.", ".$rzEvent->targetEntranceId.")); </script>";
    $i++;
}
?>
<a href="javascript: add<?=$prefix?>Event();">Add <?=ucwords($prefix)?> Event</a>
<script>i=<?=$i+1;?>;</script>
</div>
