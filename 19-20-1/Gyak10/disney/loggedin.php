<?php
require_once("adatkezeles.php");
$dalok = dalok();
function likep($cim){
    return round((dalLiked($cim))/(dalLiked($cim)+dalDisliked($cim))*100,1);
}function dislikep($cim){
    return 100-likep($cim);
}
?>

<style>
table, tr, td{
    border: 1px solid black;
    border-collapse: collapse;
}
td{
    width: 100px;
}
.liked{
    background-color: green;
}
.disliked{
    background-color: red;
}
</style>

<form action="ujdal.php">
    Cím: <input name="cim">
    Film: <input name="film">
    Előadó: <input name="eloado">
    <input type="submit" value="Új dal">
</form>

<br><br>

<a href="index.php">Szűrők ürít</a>
<table>
<?php foreach($dalok as $dal): ?>
    <?php if(!isset($_GET["szuro"]) || 
            ($_GET["szuro"] == "film" && $_GET["ertek"] == $dal->film) ||
            ($_GET["szuro"] == "enekes" && $_GET["ertek"] == $dal->enekes) ||
            ($_GET["szuro"] == "felhasznalo" && $_GET["ertek"] == $dal->felhasznalo)
    ): ?>
        <tr>
            <td
            <?php if(liked($_SESSION["uname"],$dal->cim)): ?> class="liked"
            <?php elseif(disliked($_SESSION["uname"],$dal->cim)): ?> class="disliked"
            <?php endif ?>
            ><?=$dal->cim?></td>
            <td><a href="index.php?szuro=film&ertek=<?=$dal->film?>"><?=$dal->film?></a></td>
            <td><a href="index.php?szuro=enekes&ertek=<?=$dal->enekes?>"><?=$dal->enekes?></a></td>
            <td><a href="index.php?szuro=felhasznalo&ertek=<?=$dal->felhasznalo?>"><?=$dal->felhasznalo?></a></td>
            <td><a href="like.php?type=like&cim=<?=$dal->cim?>">Like</a></td>
            <td><a href="like.php?type=dislike&cim=<?=$dal->cim?>">Dislike</a></td> 
            <td>
                <?php
                $osszeg = dalLiked($dal->cim)+dalDisliked($dal->cim);
                if($osszeg == 0): ?>
                    Nincs adat
                <?php else: ?>
                    <?php if(dalDisliked($dal->cim) > 0): ?>
                        <div class="disliked" style="display: inline-block; width:<?=dislikep($dal->cim)-1?>%;">:(</div>
                    <?php endif ?>
                    <?php if(dalLiked($dal->cim) > 0): ?>
                        <div class="liked" style="display: inline-block; width:<?=likep($dal->cim)-1?>%;">:)</div>
                    <?php endif ?>
                <?php endif ?>
            </td>          
        </tr>
    <?php endif ?>
<?php endforeach ?>
</table>