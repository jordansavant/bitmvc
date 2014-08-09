##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
 &gt; <a href="index.php?c=<?=$C?>&o=editLevel&lp=<?=$this->lp?>&lid=<?=$this->lid?>">Level</a>
##end##

<h1>Create Character</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=createCharacter&lp=<?=$this->rzLevelPack->name?>&lid=<?=$this->rzLevel->id?>&index=<?=$this->index?>" method="post">
<?php echo $this->rzCharacter->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
