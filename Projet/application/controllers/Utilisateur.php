<?php 
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

    class utilisateur extends CI_Controller {

    /**
    *Récupère les données d'inscription renseignées par l'utilisateur puis 
    *appelle la fonction create_utilisateur dans le Model.  
    *Si cette requête réussie, l'utilisateur est redirigé vers une page de
    * succès avec un bouton qui mène à la page de connexion. 
    * 
    * Pas de paramètre.
    */
	public function inscription(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('model_utilisateur');  

		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header');
			$this->load->view('vueInscription');
			$this->load->view('templates/footer');

		}else{ 

			$nom = $this->input->post('nom');
			$prenom = $this->input->post('prenom');
			$login = $this->input->post('login');
			$email = $this->input->post('email');
			$mdp = $this->input->post('mdp');
			$hash = password_hash($mdp, PASSWORD_DEFAULT);

			$data=array(
				'nom'=>$nom,
				'prenom'=>$prenom,
				'login'=> $login,
				'email'=>$email,
				'mdp'=> $hash
			);

			if	($this->model_utilisateur->create_utilisateur($data)){
				$this->load->view('templates/header');
				$this->load->view('inscriptionSuccess', $data);
				$this->load->view('templates/footer');
			} else {
                $this->load->view('templates/header');
                $this->load->view('errors/inscriptionErreur');
                $this->load->view('templates/footer');
            }
		}
	}

    /**
     * Récupère les données de connexion (login + mot de passe) de l'utilisateur
     * afin de les vérifier puis de mes envoyer dans la fonction check_utilisateur
     * du Model. Si elle réussie, l'utilisateur est redirigée vers la page 
     * d'accueil de Doodle. 
     * Si elle échoue, elle affiche un message d'erreur en fonction de celle-ci et 
     * affiche de nouveau la page de connexion.
     * 
     * Pas de paramètre.
     */
    public function connexion(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('vueConnexion');
            $this->load->view('templates/footer');

        }else{
            $login = $this->input->post('login');
            $mdp = $this->input->post('mdp');
            $hash = password_hash($mdp, PASSWORD_DEFAULT);

            $data=array(
                'login'=> $login,
                'mdp'=> $hash
            );

            $conn=$this->model_utilisateur->check_utilisateur($data);
            $valid=0;
            foreach ($conn->result_array() as $verif){
                if(password_verify($mdp,$verif['mdp'])){
                    $valid = 1;
                } else 
                    $valid = 2;
            }

            if($valid==1){
                $_SESSION['login']=$login;
                $this->load->view('templates/header');
                $this->load->view('vueDoodleAccueil',$_SESSION['login']);
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }else if($valid==2){
                $this->load->view('templates/header');
                $this->load->view('errors/mdpErreur');
                $this->load->view('vueConnexion');
                $this->load->view('templates/footer');
            }else {
                $this->load->view('templates/header');
                $this->load->view('errors/loginErreur');
                $this->load->view('vueConnexion');
                $this->load->view('templates/footer');
            }
        }
    }

    /**
     * Affiche la page d'accueil de Doodle une fois que l'utilisateur est connecté.
     * 
     * Pas de paramètre.
     */
    public function accueil(){
        $this->load->view('templates/header');
        $this->load->view('vueDoodleAccueil');
        $this->load->view('templates/footerConnecte');
        $this->load->view('templates/footer');
    }

    /**
     * Déconnecte un utilisateur, précédemment connecté. Affiche la page de connexion.
     * 
     * Pas de paramètre.
     */
    public function deconnexion(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur');

        $this->load->view('templates/header');
        $this->load->view('vueConnexion');
        $this->load->view('templates/footer');
        
        session_destroy();
    }


    /**
     * Appelle la fonction get_sondage du Model. Si cette derniere renvoie 0
     * alors un message indiquant le manque de sondage pour l'utilisateur est
     * affiché. Si elle ne renvoie pas "false" alors l'utilisateur est redirigé sur une page avec une liste de ses sondages. Sinon un message d'erreur est affiché en redirigeant l'utilisateur vers la page d'accueil. 
     * 
     * Pas de paramètre.
     */
     public function mesSondages(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        $sondages = $this->model_utilisateur->get_sondages($_SESSION['login']);
 
         if($sondages!=false){

            $_SESSION['sondages'] = $sondages;

            $this->load->view('templates/header');
            $this->load->view('vueMesSondages');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }else if($sondages==0){
            $this->load->view('templates/header');
            $this->load->view('sondagesErreur');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header');
            $this->load->view('errors/bdErreur');
            $this->load->view('vueDoodleAccueil');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }
    }

    /**
     * Récupère les données de l'utilisateur afin de créer le début d'un sondage,
     * puis les vérifie. Si aucun problème n'est détecté, alors une redirection 
     * vers la page de création 2 du sondage est effectuée. Sinon l'utilisateur 
     * reste sur cette même page avec les erreurs affichées.  
     * 
     * Pas de paramètre.
     */
    public function sondage1(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur');  

        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('vueCreationDoodle1');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }else{
            $titre = $this->input->post('titre');
            if($this->input->post('lieu')) {
                $lieu = $this->input->post('lieu');
            }
            else{
                $lieu = "";
            }
            if($this->input->post('note')) {
                $note = $this->input->post('note');
            }
            else{
                $note = "";
            }

            $_SESSION['titre']=$titre;
            $_SESSION['lieu']=$lieu;
            $_SESSION['note']=$note;

            $this->load->view('templates/header');
            $this->load->view('vueCreationDoodle2');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer'); 
        }
    }

    /**
     * Récupère la suite des données pour la création d'un sondage, puis les vérifie. Si aucun problème n'est détecté alors l'utilisateur est redirigé
     * vers la page 3 de la création du sondage. Sinon l'utilisateur reste
     * sur cette page avec les erreurs affichées. 
     * 
     * Pas de paramètre.
     */
    public function sondage2(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur');


        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('vueCreationDoodle2');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }else{
            $dateDebut = $this->input->post('dateDebut');
            $dateFin = $this->input->post('dateFin');

            $dateDebutDiv = explode('-',$dateDebut);
            $dateFinDiv = explode('-',$dateFin);

            $valid=false;

            if($dateFinDiv[0]>$dateDebutDiv[0]){//annee
                $valid = true ;
            }else if($dateFinDiv[0]==$dateDebutDiv[0]){ //annee
                if($dateFinDiv[1]>$dateDebutDiv[1]){ //mois
                    $valid = true ;
                }else if($dateFinDiv[1]==$dateDebutDiv[1]){ //mois
                    if($dateFinDiv[2]>=$dateDebutDiv[2]){ //jour
                        $valid = true ; 
                    }
                }
            }else{
                $valid = false ;
            }

            if(!$valid){
                $this->load->view('templates/header');
                $this->load->view('errors/dateErreur');
                $this->load->view('vueCreationDoodle2');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');

            }else{
                $_SESSION['dateDebut']=$dateDebut;
                $_SESSION['dateFin']=$dateFin;

                $this->load->view('templates/header');
                $this->load->view('vueCreationDoodle3');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer'); 
            }
        }
    }

    /**
     * Récupère la troisième partie des données de la création du sondage puis les
     * vérifie. Si aucun problème n'est détecté, l'utilisateur est redirigé vers 
     * la dernière page de création de ce sondage. Sinon l'utilisateur reste sur cette même page avec les erreurs affichées. 
     * 
     * Pas de paramètre.
     */
    public function sondage3(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('vueCreationDoodle3');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }else{
            $heureDebut = $this->input->post('heureDebut');
            $heureFin = $this->input->post('heureFin');

            $heureDebutDiv = explode(':',$heureDebut);
            $heureFinDiv = explode(':',$heureFin);

            if($heureFinDiv[0] > $heureDebutDiv[0]){ //heure
                $valid = true ;
            }else if($heureFinDiv[0] == $heureDebutDiv[0]){ //heure
                if($heureFinDiv[1] >= $heureDebutDiv[1]){ //min
                    $valid = true ; 
                }
            }else{
                $valid = false ; 
            } 

            if(!$valid){
                $this->load->view('templates/header');
                $this->load->view('errors/heureErreur');
                $this->load->view('vueCreationDoodle3');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }else{  
                $_SESSION['heureDebut'] = $heureDebut;
                $_SESSION['heureFin'] = $heureFin;

                $this->load->view('templates/header');
                $this->load->view('vueCreationDoodle4');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }
        }                  
    }

    /**
     * Récupère les dernières données du sondage et les vérifie.
     * Si aucun problème n'est détecté, la fonction appelle verif_sondage du 
     * Model. 
     *      Si elle ne renvoie pas "false" alors l'utilisateur est redirigé vers  
     * la page de récapitulation du sondage en ajoutant un message comme quoi le 
     * sondage est déjà créé. 
     *      Sinon la clé de ce sondage est créée. Ensuite la fonction 
     * create_sondage est appelée.
     *          Si elle échoue elle renvoie une message d'erreur en redirigeant
     * l'utilisateur vers la première page de création d'un sondage.
     *          Sinon elle affiche la page de récapitulatif.
     * Sinon l'utilisateur reste sur la même page avec les erreurs affichées.
     * 
     * Pas de paramètre. 
     */
    public function sondage4(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('vueCreationDoodle4');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }else{
            $nom = $this->input->post('nom');
            $email = $this->input->post('email');

            $_SESSION['nom']=$nom;
            $_SESSION['email']=$email;
           
            $data=array(
                'login'=> $_SESSION['login'],
                'titre' => $_SESSION['titre'],
                'lieu' => $_SESSION['lieu'],
                'note' => $_SESSION['note'],
                'heureDebut'=> $_SESSION['heureDebut'],
                'heureFin'=> $_SESSION['heureFin'],
                'dateDebut' => $_SESSION['dateDebut'],
                'dateFin' => $_SESSION['dateFin'],
                'nom' => $_SESSION['nom'],
                'email' => $_SESSION['email'],
            );

            $query = $this->model_utilisateur->verif_sondage($data);

            if($query!=false){
                foreach ($query->result_array() as $sondage) {
                    $data=array(
                    'cle'=> $sondage['cle'],
                    'login'=> $_SESSION['login'],
                    'titre' => $_SESSION['titre'],
                    'lieu' => $_SESSION['lieu'],
                    'note' => $_SESSION['note'],
                    'heureDebut'=> $_SESSION['heureDebut'],
                    'heureFin'=> $_SESSION['heureFin'],
                    'dateDebut' => $_SESSION['dateDebut'],
                    'dateFin' => $_SESSION['dateFin'],
                    'nom' => $_SESSION['nom'],
                    'email' => $_SESSION['email'],
                    );
                }
                $this->load->view('templates/header');
                $this->load->view('errors/sondageDejaCreeErreur');
                $this->load->view('vueRecapitulatifDoodle',$data);
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }else{
                $cle = "";
                $chaine= "azertyuiopmlkjhgfdsqwxcvbn1234567890";
                for ($i=0; $i<65; $i++){
                    $cle .= $chaine[rand()%strlen($chaine)];
                }
                $_SESSION['cle']=$cle;

                $data=array(
                    'cle'=> $_SESSION['cle'],
                    'login'=> $_SESSION['login'],
                    'titre' => $_SESSION['titre'],
                    'lieu' => $_SESSION['lieu'],
                    'note' => $_SESSION['note'],
                    'heureDebut'=> $_SESSION['heureDebut'],
                    'heureFin'=> $_SESSION['heureFin'],
                    'dateDebut' => $_SESSION['dateDebut'],
                    'dateFin' => $_SESSION['dateFin'],
                    'nom' => $_SESSION['nom'],
                    'email' => $_SESSION['email'],
                );
                
                if($this->model_utilisateur->create_sondage($data)){
                    $this->load->view('templates/header');
                    $this->load->view('vueRecapitulatifDoodle',$data);
                    $this->load->view('templates/footerConnecte');
                    $this->load->view('templates/footer');
                }else{
                    $this->load->view('templates/header');
                    $this->load->view('errors/bdErreur');
                    $this->load->view('vueCreationDoodle1');
                    $this->load->view('templates/footerConnecte');
                    $this->load->view('templates/footer');
                }
            }
        }
    }

    /**
     * Appelle la fonction delete_sondage du Model.
     * Si elle réussie, alors appelle la fonction get_sondage du Model.
     *      Si elle ne renvoie pas "false" alors l'utilisateur reste sur la page
     * de ses sondages avec un message de réussite en plus.
     *      Si elle renvoie 0 alors l'utilisateur reste sur la même page avec un
     * message d'erreur indiquant que l'utilisateur n'a pas de sondage.
     *      Sinon l'utilisateur est redirigé vers la page d'accueil de Doodle avec
     * un message d'erreur.
     * Sinon appelle tout de même la fonction get_sondage.
     *      Si elle ne renvoie pas "false" alors l'utilisateur reste sur la même
     * page de ses sondages avec un message d'erreur de suppression.
     *      Si elle renvoie 0 alors l'utilisateur reste sur la même page avec deux
     * messages d'erreurs (probleme de suppression + pas de sondage)
     *      Sinon l'utilisateur est redirigé vers la page d'accueil de Doodle avec
     * deux messages d'erreur (probleme de suppression + probleme de base de 
     * données).
     * 
     * @param String $cle
     */
    public function suppsondage($cle){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        if($this->model_utilisateur->delete_sondage($cle)){
            $sondages = $this->model_utilisateur->get_sondages($_SESSION['login']);
 
            if($sondages!=false){
                $_SESSION['sondages'] = $sondages;

                $this->load->view('templates/header');
                $this->load->view('suppSondageSuccess');
                $this->load->view('vueMesSondages');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');

            }else if($sondages==0){
                $this->load->view('templates/header');
                $this->load->view('errors/pasSondageBd');
                $this->load->view('vueMesSondages');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header');
                $this->load->view('errors/bdErreur');
                $this->load->view('vueDoodleAccueil');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }

        }else{
            $sondages = $this->model_utilisateur->get_sondages($_SESSION['login']);
     
            if($sondages!=false){

                $_SESSION['sondages'] = $sondages;

                $this->load->view('templates/header');
                $this->load->view('errors/suppSondageErreur');
                $this->load->view('vueMesSondages');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }else if($sondages==0){
                $this->load->view('templates/header');
                $this->load->view('errors/suppSondageErreur');
                $this->load->view('errors/pasSondageBd');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header');
                $this->load->view('errors/suppSondageErreur');
                $this->load->view('errors/bdErreur');
                $this->load->view('vueDoodleAccueil');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }
        }
    }

    /**
     * Appelle la fonction get_sondage_cle. 
     * Si elle ne renvoie pas "false" alors elle vérifie si le sondage est cloturé
     * ou non. 
     *      S'il n'est pas cloturé alors la page de vote du sondage en question
     * est affiché.
     *      Sinon un message indiquant la cloturation du sondage est affiché. 
     * Sinon l'utilisateur est redirigé vers une page indiquant une erreur sur la 
     * clé.
     * 
     * @param String $cle
     */
    public function lien($cle){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 
        
        $verif = $this->model_utilisateur->get_sondage_cle($cle);
        if ($verif!=false){
            foreach ($verif->result_array() as $sondage) {
                if($sondage['cloturer']==false){
                    $_SESSION['cleRecue'] = $cle;

                    $mois = array(
                        '1' => '31',
                        '2' => '28',
                        '3' => '31',
                        '4' => '30',
                        '5' => '31',
                        '6' => '30',
                        '7' => '31',
                        '8' => '31',
                        '9' => '30',
                        '10' => '31',
                        '11' => '30',
                        '12' => '31'
                    );
                        $ANNEE= 365;
                    if($sondage['dateDebut']===$sondage['dateFin']){
                        $nbrejour = 0;
                    }else{
                        $dateDebutDiv = explode('-',$sondage['dateDebut']);
                        $dateFinDiv = explode('-',$sondage['dateFin']);
                        $dateDebutDiv[1] +=1-1;
                        $dateFinDiv[1] +=1-1;

                        $nbreannee = $dateFinDiv[0]-$dateDebutDiv[0];
                        

                        $nbrejour=0;
                        $nbrejourTrop=0;

                        if ( $dateFinDiv[1] >  $dateDebutDiv[1]){
                            for ($i=$dateDebutDiv[1]; $i<$dateFinDiv[1]; $i++){
                                $nbrejour += $mois[$i];
                            }
                            $nbrejour += $nbreannee*$ANNEE -$dateDebutDiv[2] + $dateFinDiv[2]; 
                        } else if ( $dateFinDiv[1] <  $dateDebutDiv[1]){
                            for ($i=$dateFinDiv[1]; $i<$dateDebutDiv[1]; $i++){
                                $nbrejourTrop += $mois[$i];
                            }
                            $nbrejour = $nbreannee*$ANNEE -$dateDebutDiv[2] + $dateFinDiv[2] - $nbrejourTrop;
                        } else if ($dateFinDiv[1] ==  $dateDebutDiv[1]){
                            $nbrejour += $nbreannee*$ANNEE -$dateDebutDiv[2] + $dateFinDiv[2] ; 
                        }
                    }
                    $data = array(
                        'titre' => $sondage['titre'],
                        'lieu' => $sondage['lieu'],
                        'note' => $sondage['note'],
                        'dateDebut' => $sondage['dateDebut'],
                        'dateFin' => $sondage['dateFin'],
                        'heureDebut' => $sondage['heureDebut'],
                        'heureFin' => $sondage['heureFin'],
                        'nbrejour' => $nbrejour,
                        'mois' => $mois
                    );

                    $this->load->view('templates/header');
                    $this->load->view('vueVote', $data);
                    $this->load->view('templates/footer');
                }else{
                    $this->load->view('templates/header');
                    $this->load->view('cloturationMessage');
                    $this->load->view('templates/footer');
                }
            }
        } else if($verif==false){
            $this->load->view('templates/header');
            $this->load->view('errors/cleErreur');
            $this->load->view('templates/footer');
        }
    }

    /**
     * Récupère les données de vote de l'utilisateur et les vérifie.
     * Appelle par la suite la fonction verif_vote du Model. 
     * Si elle réussie alors un appel à la fonction update_vote du Model
     * est effectué.
     *      Si cette dernière réussie alors l'utilisateur est redirigé vers
     * une page de succès de vote.
     * Si elles échouent alors l'utilisateur est redirigé vers une page d'erreur
     * de vote.
     * Cependant, si l'utilisateur ne coche aucun case lors du vote, il est
     * redirigé vers une page indiquant son manque de vote.
     * 
     * Pas de paramètre.
     */
    public function vote(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        $nom = $this->input->post('nom');
        $cle = $_SESSION['cleRecue'];
        $recupCode = $this->input->post('code');
        $valid = true;
        $n=0;
        if (isset($recupCode)){
            foreach($recupCode as $code ){
                $n++;
                if ($valid = true){
                    $data = array(
                        'cle' => $cle, 
                        'nom' => $nom,
                        'code' => $code
                    );
                    $query = $this->model_utilisateur->verif_vote($data);
                    if($query==true){
                        if($this->model_utilisateur->update_vote($data)){
                           $valid = true;
                        }else {
                          $valid = false;
                       }
                    }else if ($query==false){
                        $valid = false ; 
                    }
                }
            }
        }
        if ($n==0){
            $data=array('cle'=> $cle);
            $this->load->view('templates/header');
            $this->load->view('errors/pasVoteErreur',$data); 
            $this->load->view('templates/footer');
        }else if($valid===true){
            $data=array('nom' =>$nom);

            $this->load->view('templates/header');
            $this->load->view('voteSuccess',$data);
            $this->load->view('templates/footer');
        }else if ($valid===false){
            $this->load->view('templates/header');
            $this->load->view('errors/voteErreur',$data); 
            $this->load->view('templates/footer');
        }
    }

    /**
     * Appelle la fonction get_vote du Model.
     * Si elle réussie alors un appel à la fonction get_sondage_cle.
     *      Si cette dernière réussie alors l'utilisateur est redirigée vers une 
     * page affichant les résultats du sondge choisi.
     * Si elles échouent alors l'uitlisateur est redirigé vers une page affichant
     * un message d'erreur.
     * 
     * @param String $cleRecue
     */
    public function voirResultats($cleRecue){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

                    $mois = array(
                        '1' => '31',
                        '2' => '28',
                        '3' => '31',
                        '4' => '30',
                        '5' => '31',
                        '6' => '30',
                        '7' => '31',
                        '8' => '31',
                        '9' => '30',
                        '10' => '31',
                        '11' => '30',
                        '12' => '31'
                    );

                    $ANNEE= 365;

        if($query=$this->model_utilisateur->get_vote($cleRecue)){
            if($query2=$this->model_utilisateur->get_sondage_cle($cleRecue)){

                foreach ($query2->result_array() as $sondage) {
                if($sondage['dateDebut']===$sondage['dateFin']){
                    $nbrejour = 0;
                }else{
                    $dateDebutDiv = explode('-',$sondage['dateDebut']);
                    $dateFinDiv = explode('-',$sondage['dateFin']);

                    $nbreannee = $dateFinDiv[0]-$dateDebutDiv[0];
                    $nbremois = $dateFinDiv[1]-$dateDebutDiv[1];
                    $dateDebutDiv[1] +=1-1;
                    $dateFinDiv[1] +=1-1;

                    $nbreannee = $dateFinDiv[0]-$dateDebutDiv[0];
                                
                    $nbrejour=0;
                    $nbrejourTrop=0;

                    if ( $dateFinDiv[1] >  $dateDebutDiv[1]){
                        for ($i=$dateDebutDiv[1]; $i<$dateFinDiv[1]; $i++){
                            $nbrejour += $mois[$i];
                        }
                        $nbrejour += $nbreannee*$ANNEE -$dateDebutDiv[2] + $dateFinDiv[2]; 
                    } else if ( $dateFinDiv[1] <  $dateDebutDiv[1]){
                        for ($i=$dateFinDiv[1]; $i<$dateDebutDiv[1]; $i++){
                            $nbrejourTrop += $mois[$i];
                        }
                        $nbrejour = $nbreannee*$ANNEE -$dateDebutDiv[2] + $dateFinDiv[2] - $nbrejourTrop;
                    } else if ($dateFinDiv[1] ==  $dateDebutDiv[1]){
                        $nbrejour += $nbreannee*$ANNEE -$dateDebutDiv[2] + $dateFinDiv[2] ; 
                    }
                }
                 $data = array(
                    'login'=> $_SESSION['login'],
                    'titre' => $sondage['titre'],
                    'lieu' => $sondage['lieu'],
                    'note' => $sondage['note'],
                    'dateDebut' => $sondage['dateDebut'],
                    'dateFin' => $sondage['dateFin'],
                    'heureDebut' => $sondage['heureDebut'],
                    'heureFin' => $sondage['heureFin'],
                    'nbrejour' => $nbrejour,
                    'mois' => $mois,
                    'query'=>$query
                 );
            }
                $this->load->view('templates/header');
                $this->load->view('vueResultats',$data);
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            } else {
                $this->load->view('templates/header');
                $this->load->view('errors/resultatsErreur');
                $this->load->view('templates/footerConnecte');
                $this->load->view('templates/footer');
            }
        }else{
            $this->load->view('templates/header');
            $this->load->view('errors/resultatsErreur');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }
    }

    /**
     * Appelle la fonction update_sondage du Model. 
     * Si elle réussie alors un appel de la fonction get_sondage du Model
     * est effectué.
     *      Si cette dernière n'est pas égale à "false" alors l'utilisateur est redirigé vers ses sondages.
     *      Si elle renvoie 0 alors l'utilisateur est redirigé vers une page 
     * avec un message d'erreur.
     * Si elles échouent l'utilisateur est redirigé vers la page d'accueil de 
     * Doodle avec un message d'erreur.
     * 
     * @param String $cle
     */
    public function cloturer($cle){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        if ($this->model_utilisateur->update_sondage($cle)){
            if($sondages = $this->model_utilisateur->get_sondages($_SESSION['login'])){
                if($sondages!=false){
                    $_SESSION['sondages'] = $sondages;

                    $this->load->view('templates/header');
                    $this->load->view('cloturationMessage');
                    $this->load->view('vueMesSondages');
                    $this->load->view('templates/footerConnecte');
                    $this->load->view('templates/footer');
            
                }else if($sondages==0){
                    $this->load->view('templates/header');
                    $this->load->view('pasSondageBd');
                    $this->load->view('templates/footerConnecte');
                    $this->load->view('templates/footer');
                }else{
                    $this->load->view('templates/header');
                    $this->load->view('errors/bdErreur');
                    $this->load->view('vueDoodleAccueil');
                    $this->load->view('templates/footerConnecte');
                    $this->load->view('templates/footer');
                }
            }
        } else {
            $this->load->view('templates/header');
            $this->load->view('errors/bdErreur');
            $this->load->view('vueDoodleAccueil');
            $this->load->view('templates/footerConnecte');
            $this->load->view('templates/footer');
        }
    }

    /**
     * Appelle la fonction delete_utilisateur du Model.
     * Si elle échoue, l'utilisateur est renvoyé sur une page d'erreur.
     * Sinon l'utilisateur est redirigé vers la page d'insciption avec un message
     * de succès en plus.
     * 
     * Pas de paramètre.
     */
    public function desinscription(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('model_utilisateur'); 

        if($this->model_utilisateur->delete_utilisateur($_SESSION['login'])){
            session_destroy();
            $this->load->view('templates/header');
            $this->load->view('desinscriptionSuccess');
            $this->load->view('vueInscription');
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header');
            $this->load->view('errors/desinscriptionErreur');
            $this->load->view('vueMesSondages');
            $this->load->view('templates/footer');
        }
    }


    /**
     * Affiche la page d'accueil du site. 
     * 
     * Pas de paramètre.
     */
    public function index(){
        $this->load->helpers('form');
        $this->load->model('model_utilisateur');
        $this->load->library('table');

        $this->load->view('templates/header');
        $this->load->view('vueAccueil');
        $this->load->view('templates/footer');
    }
}

?>