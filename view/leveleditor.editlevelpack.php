<?php
$lp = $args['rzLevelPack']->name;
?>
<h1>Edit Level Pack: <?=$lp?></h1>
<ul>
<?php
foreach($args['rzLevelPack']->levels as $rzLevel)
{
?>
    <li><?=$rzLevel->title?> - <a href="index.php?c=<?=$C?>&o=editlevel&lp=<?=$lp?>&levelid=<?=$rzLevel->id?>">edit</a></li>
<?php
}
?>
</ul>
<a href="index.php?c=<?=$C?>&o=createLevel&lp=<?=$lp?>">Create Level</a>
