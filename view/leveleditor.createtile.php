<h1>Create Tile</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=createTile&lp=<?=$this->rzLevelPack->name?>&lid=<?=$this->rzLevel->id?>&index=<?=$this->index?>" method="post">
<?php echo $this->rzTile->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
