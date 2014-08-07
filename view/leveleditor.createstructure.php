<h1>Create Structure</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=createStructure&lp=<?=$this->rzLevelPack->name?>&lid=<?=$this->rzLevel->id?>&index=<?=$this->index?>" method="post">
<?php echo $this->rzStructure->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
