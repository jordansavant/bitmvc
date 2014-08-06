<h1>Index</h1>
<ul>
<?php
foreach($this->files as $file)
{
?>
    <li>
        <?=$file?> -
        <a href="index.php?c=<?=$C?>&o=editlevelpack&lp=<?=$file?>">edit</a> -
        <a href="index.php?c=<?=$C?>&o=viewlevelpacksource&lp=<?=$file?>">source</a>
    </li>
<?php
}
?>
</ul>
<a href="index.php?c=leveleditor&o=createLevelpack">Create Levelpack</a>
