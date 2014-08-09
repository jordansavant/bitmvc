<div id="lighttool">
<script>
var i=0;
function buildLight(index, radius, red, green, blue, brightness)
{
    return '<div id="light'+ index +'"> radius:<input type="text" class="ss" name="lighttool[light_radiuses][]" value="'+radius+'" /> R:<input type="text" class="ss" name="lighttool[light_reds][]" value="'+red+'" /> G:<input type="text" class="ss" name="lighttool[light_greens][]" value="'+green+'" /> B:<input type="text" class="ss" name="lighttool[light_blues][]" value="'+blue+'" /> bri:<input type="text" class="ss" name="lighttool[light_brights][]" value="'+brightness+'" /> <a class="lt" href="#">C</a> <a href="javascript: removeLight('+ index +');">X</a></div>'
}
function addLight()
{
    $('#lights').append(buildLight(i, 3, 255, 255, 255, 1));
    i++;
}
function removeLight(index)
{
    $('#light'+index).remove();
}
</script>
<div id="lights"></div>
<?php
$i=0;
foreach($args['lights'] as $rzLight)
{
    echo "<script> $('#lights').append(buildLight($i, ".$rzLight->radius.", ".$rzLight->red.", ".$rzLight->green.", ".$rzLight->blue.", ".$rzLight->brightness."));</script>";
    $i++;
}
?>
<a href="javascript: addLight();">Add Light</a>
<script>i=<?=$i+1;?>;</script>
<script>
$('.lt').ColorPicker({
    onSubmit: function(hsb, hex, rgb, el) {
        var d = $(el).parent();
        var red = d.children('[name="lighttool[light_reds][]"]')[0];
        var green = d.children('[name="lighttool[light_greens][]"]')[0];
        var blue = d.children('[name="lighttool[light_blues][]"]')[0];
        $(red).val(rgb.r);
        $(green).val(rgb.g);
        $(blue).val(rgb.b);
    },
    onShow: function(a, b, c, d) {
        var d = $(this).parent();
        var red = d.children('[name="lighttool[light_reds][]"]')[0];
        var green = d.children('[name="lighttool[light_greens][]"]')[0];
        var blue = d.children('[name="lighttool[light_blues][]"]')[0];
        console.log(red, green, blue, d);
        $(this).ColorPickerSetColor({r: $(red).val(), g: $(green).val(), b: $(blue).val()});
    }
});
</script>
</div>
