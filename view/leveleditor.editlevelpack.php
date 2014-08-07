<?php
$lp = $this->rzLevelPack->name;
?>
<h1>Edit Level Pack: <?=$lp?></h1>
<ul>
<?php
foreach($this->rzLevelPack->levels as $rzLevel)
{
?>
    <li><?=$rzLevel->title?> - <a href="index.php?c=<?=$C?>&o=editlevel&lp=<?=$lp?>&lid=<?=$rzLevel->id?>">edit</a></li>
<?php
}
?>
</ul>
<a href="index.php?c=<?=$C?>&o=createLevel&lp=<?=$lp?>">Create Level</a>
