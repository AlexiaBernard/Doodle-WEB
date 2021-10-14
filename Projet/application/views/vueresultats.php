<?php
include "securite.php";
?>

<div>
	<h2>Résultats</h2> 
	<br><br>
	<div class="info2">
		<?php
			$mintitre=strtolower($titre);
			$titre=ucfirst($mintitre);
			$minlogin=strtolower($login);
			$login=ucfirst($minlogin);
			echo "<legend>Nom du sondage : $titre<br>
					Créé par : $login<br>";
					if ($lieu!=""){
						echo "Lieu : $lieu</legend><br>";	
					}
					if ($note!=""){
						echo "Note : $note</legend><br>";
					}
		?>
		<br>
	<?=anchor("utilisateur/mesSondages","<button>Mes sondages</button>");?>
	</div>
    <div class="tableau">
		<fieldset>
			<table>

			<?php

			$dateDebutDiv = explode('-',$dateDebut);
			$dateFinDiv = explode('-',$dateFin);

			echo "<tr><td> </td>";
			$dateDebutDiv[2] = $dateDebutDiv[2] +1 -1; //permet d'enlever le 0 de devant 
			$dateDebutDiv[1] = $dateDebutDiv[1] +1 -1;

			$jourdepart = $dateDebutDiv[2];
			$moisdepart =  $dateDebutDiv[1];

			for($an=$dateDebutDiv[0]; $an<=$dateFinDiv[0]; $an++){
				if ($an==$dateFinDiv[0]){
					for($m=$moisdepart; $m<=$dateFinDiv[1]; $m++){
						if($m==$dateFinDiv[1] && $an==$dateFinDiv[0]){
							for($j=$jourdepart; $j<=$dateFinDiv[2]; $j++){
								if($m<10){
									if($j<10){
									echo "<td>0".$j."/0".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/0".$m."/".$an."</td>";
								} else  {
									if($j<10){
									echo "<td>0".$j."/".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/".$m."/".$an."</td>";
								}
							}
						}else{
							for($j=$jourdepart; $j<=$mois[$m]; $j++){
								if($m<10){
									if($j<10){
									echo "<td>0".$j."/0".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/0".$m."/".$an."</td>";
								} else  {
									if($j<10){
									echo "<td>0".$j."/".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/".$m."/".$an."</td>";
								}
							}
						}
						$jourdepart = 1;
					} 
				}else {
					for($m=$moisdepart; $m<=12; $m++){
						if($m==$dateFinDiv[1] && $an==$dateFinDiv[0]){
							for($j=$jourdepart; $j<=$dateFinDiv[2]; $j++){
								if($m<10){
									if($j<10){
									echo "<td>0".$j."/0".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/0".$m."/".$an."</td>";
								} else  {
									if($j<10){
									echo "<td>0".$j."/".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/".$m."/".$an."</td>";
								}
							}
						}else{
							for($j=$jourdepart; $j<=$mois[$m]; $j++){
								if($m<10){
									if($j<10){
									echo "<td>0".$j."/0".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/0".$m."/".$an."</td>";
								} else  {
									if($j<10){
									echo "<td>0".$j."/".$m."/".$an."</td>";
									} else
									echo "<td>".$j."/".$m."/".$an."</td>";
								}
							}
						}
						$jourdepart = 1;
					} $moisdepart=1;
				}
			}
			echo "</tr>";
			$heureDebutDiv = explode(':',$heureDebut);
			$heureFinDiv = explode(':',$heureFin);
			?>
			<?php
			$separateur = 'z';
			if( ($heureDebutDiv[0]===$heureFinDiv[0]) && ($heureDebutDiv[1]===$heureFinDiv[1]) ){
					echo "<tr><td>$heureFinDiv[0]:$heureFinDiv[1]</td>";
					for($a=0;$a<=$nbrejour;$a++){
						echo "<td>";
						$verif=0;
						foreach($query->result() as $row){
							if($row->code=="$heureDebutDiv[0]"."$separateur"."$heureDebutDiv[1]"."$separateur"."$a"){
		   						echo "$row->nom<br>";
		    					$verif++;
							}
						}
						if($verif==0){
							echo "X";
						}
						echo "</td>";
					}
			}else{
				$heureDebutDiv[1]+=1-1;
				$heureFinDiv[1]+=1-1;
				$heureDebutDiv[0]+=1-1;
				$heureFinDiv[0]+=1-1;


				$k = $heureDebutDiv[1];
				$i = $heureDebutDiv[0];
				while($i<=$heureFinDiv[0]){
					if($k>=60){
						$i++;
						$k = $k-60;
					}
					if($i<10){
						if($k<10){
							echo "<tr><td>0$i:0$k</td>";
							$fin=$k;
						}else{
							echo "<tr><td>0$i:$k</td>";
							$fin=$k;
						}
					}else{
						if($k<=10){
							echo "<tr><td>$i:0$k</td>";
							$fin=$k;
						}else{
							echo "<tr><td>$i:$k</td>";
							$fin=$k;
						}
					}
					for($a=0;$a<=$nbrejour;$a++){
						echo "<td>";
						$verif=0;
						foreach($query->result() as $row){
							if($row->code=="$i"."$separateur"."$k"."$separateur"."$a"){
		   							echo "$row->nom<br>";
		    					$verif++;
							}
						}
						if($verif==0){
							echo "X";
						}
						echo "</td>";
					}
					echo "</tr>";
					$k+=30;
					if(($k>$heureFinDiv[1]) && ($i==$heureFinDiv[0])){
						$k= $heureFinDiv[1];
						break ;
					}
				}
				if ($fin<$heureFinDiv[1]){
					if($heureFinDiv[0]<10){
						if($heureFinDiv[0]==0){
							echo "<tr><td>$heureFinDiv[0]:$heureFinDiv[1]</td>";
						}else if($heureFinDiv[1]<10){
							echo "<tr><td>0$heureFinDiv[0]:0$heureFinDiv[1]</td>";
						}else{
							echo "<tr><td>0$heureFinDiv[0]:$heureFinDiv[1]</td>";
						}
					}else{
						if($heureFinDiv[1]<10){
							echo "<tr><td>$heureFinDiv[0]:0$heureFinDiv[1]</td>";
						}else{
							echo "<tr><td>$heureFinDiv[0]:$heureFinDiv[1]</td>";
						}
					}
					for($a=0;$a<=$nbrejour;$a++){
						echo "<td>";
						$verif=0;
						foreach($query->result() as $row){
							if($row->code=="$i"."$separateur"."$k"."$separateur"."$a"){
		   						echo "$row->nom<br>";
		    					$verif++;
							}
						}
						if($verif==0){
							echo "X";
						}
						echo "</td>";
					}
					echo "</tr>";
				}
			}
			?>
			</table>
		</fieldset>
	</div>
</div>