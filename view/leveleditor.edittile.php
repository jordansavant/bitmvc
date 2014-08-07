##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
 &gt; <a href="index.php?c=<?=$C?>&o=editLevel&lp=<?=$this->lp?>&lid=<?=$this->lid?>">Level</a>
##end##

<h1>Edit Tile</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=editTile&lp=<?=$this->lp?>&lid=<?=$this->lid?>&tid=<?=$this->tid?>" method="post">
<?php
echo $this->rzTile->toForm();
?>
<br>
<input type="submit" value="Save Tile" />
</form>
