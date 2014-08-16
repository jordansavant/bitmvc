<?php
$prefix = "";
?>
<div id="eventtool">
<script>
var i=0;
function buildEvent(index, dd, tli, tei)
{
    return '<div id="event'+ index +'"> '+dd+' Level ID:<input type="text" class="sss" name="eventtool[event_tli][]"" value="'+tli+'" /> Entrance ID:<input type="text" class="sss" name="eventtool[event_tei][]"" value="'+tei+'" /> <a href="javascript: removeEvent('+ index +');">X</a></div>'
}
function addEvent()
{
    $('#events').append(buildEvent(i, '<?php echo RZConfig::buildEventDD('eventtool[events][]');?>', 0, 0));
    i++;
}
function removeEvent(index)
{
    $('#event'+index).remove();
}
</script>
<div id="events"></div>
<?php
$i=0;
foreach($args['events'] as $rzEvent)
{
    echo "<script>$('#events').append(buildEvent($i, '". RZConfig::buildEventDD('eventtool[events][]', $rzEvent->type) ."', ".$rzEvent->targetLevelId.", ".$rzEvent->targetEntranceId.")); </script>";
    $i++;
}
?>
<a href="javascript: addEvent();">Add Event</a>
<script>i=<?=$i+1;?>;</script>
</div>
