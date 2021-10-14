<?php
include "securite.php";
?>

<br>
<table>
	<tr>
		<td>Titre</td>
		<td>Lieu</td>
		<td>Note</td>
		<td>Lien</td>
		<td></td>
		<td></td>
	</tr>	
	<?php
		$sondages = $_SESSION['sondages'];
		foreach ($sondages->result_array() as $sondage){
			echo "<tr><td>{$sondage['titre']}</td>
					<td>{$sondage['lieu']}</td>
					<td>{$sondage['note']}</td>";

			if($sondage['cloturer']==false){
				echo "<td>".anchor("utilisateur/cle/{$sondage['cle']}","<i class='fa fa-share-square-o'style='font-size:150%; color:black'></i>",array())."</td>";
			}else{
				echo "<td></td>";
			}

			echo "<td>".anchor("utilisateur/voirResultats/{$sondage['cle']}","<button>Voir Résultats</button>",array())."</td>";

			if($sondage['cloturer']==false){
			echo "<td>".anchor("utilisateur/cloturer/{$sondage['cle']}","<button>Clôturer</button>",array())."</td>";
			}else{
				echo "<td></td>";
			}	
			
			echo "<td>".anchor("utilisateur/suppsondage/{$sondage['cle']}","<i class='fa fa-trash' style='font-size:150%; color:black'></i>",array())."</td>	
			</tr>";
		}
	?>
</table>