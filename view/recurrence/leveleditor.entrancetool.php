<?php
$prefix = isset($args['prefix']) ? $args['prefix'] : '';
?>
<div id="<?=$prefix?>entrancetool">
<script>
var i=0;
function build<?=$prefix?>Entrance(index, id, prio)
{
    return '<div id="<?=$prefix?>entrance'+ index +'"> ID:<input type="text" class="sss" name="<?=$prefix?>entrancetool[id][]"" value="'+id+'" /> Priority:<input type="text" class="sss" name="<?=$prefix?>entrancetool[priority][]"" value="'+prio+'" /> <a href="javascript: remove<?=$prefix?>Entrance('+ index +');">X</a></div>'
}
function add<?=$prefix?>Entrance()
{
    $('#<?=$prefix?>entrances').append(build<?=$prefix?>Entrance(i, 0, 0));
    i++;
}
function remove<?=$prefix?>Entrance(index)
{
    $('#<?=$prefix?>entrance'+index).remove();
}
</script>
<div id="<?=$prefix?>entrances"></div>
<?php
$i=0;
foreach($args['entrances'] as $rzEntrance)
{
    echo "<script>$('#${prefix}entrances').append(build${prefix}Entrance($i, $rzEntrance->id, $rzEntrance->priority)); </script>";
    $i++;
}
?>
<a href="javascript: add<?=$prefix?>Entrance();">Add <?=ucwords($prefix)?> Entrance</a>
<script>i=<?=$i+1;?>;</script>
</div>
