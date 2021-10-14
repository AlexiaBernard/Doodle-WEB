<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_utilisateur extends CI_Model {

	/**
     * Lien de connexion entre le site et la base de donnée.
     */
	public function __construct(){
		$this->load->database();
	}

	/**
     * Insert l'utilisateur dans la table utilisateur.
     * @param $data ensemble de données nécessaires à l'insertion du tuple
     * @return la requête
     */
	public function create_utilisateur($data){
		return	$this->db->insert('utilisateur', $data);	
	}

	/**
     * Vérifie que l'utilisateur est dans la base de donnée
     * @param $data ensemble de données nécessaires à la selection du tuple
     * @return la requête
     */
	public function check_utilisateur($data){
		$this->db->select('*')
			 ->from('utilisateur')
			 ->where('login',$data['login']);
		$query = $this->db->get();

		return $query; 
	}

	/**
     * Suppression d'un utilisateur ce qui entraine la suppression de ces sondages et des votes associés
     * @param $login identifiant de l'utilisateur
     * @return la requête
     */
	public function delete_utilisateur($login){
		$this->db->select('*')
			 ->from('sondage')
			 ->where('login',$login);
		$query = $this->db->get();

		foreach ($query->result_array() as $sondage) {
			$this->db->where('cle', $sondage['cle']);
			$this->db->delete('vote');

			$this->db->where('cle', $sondage['cle']);
			$this->db->delete('sondage');
		}

		$this->db->where('login', $login);
		return ($this->db->delete('utilisateur'));	
	}

	/**
     * Insert un sondage dans la table sondage.
     * @param $data ensemble de données nécessaires à l'insertion du tuple
     * @return la requête
     */
	public function create_sondage($data){
		return $this->db->insert('sondage', $data);
	}

	/**
     * Vérifie que le sondage n'est pas déja créé dans la base de donnée
     * @param $data ensemble de données nécessaires à la séléction du tuple
     * @return true ou false si la requête est réussi ou non
     */
	public function verif_sondage($data){
		$this->db->select('*')
			 ->from('sondage')
			 ->where('login',$data['login'])
			 ->where('titre',$data['titre'])
			 ->where('lieu',$data['lieu'])
			 ->where('note',$data['note'])
			 ->where('heureDebut',$data['heureDebut'])
			 ->where('heureFin',$data['heureFin'])
			 ->where('dateDebut',$data['dateDebut'])
			 ->where('dateFin',$data['dateFin'])
			 ->where('nom',$data['nom'])
			 ->where('email',$data['email']);
		$query = $this->db->get();
		if($query->num_rows()==0)
			return false;
		else 
			return $query;
	}

	/**
     * Récupere les sondages pour un utilisateur en particulier
     * @param $login utilisateur demandé
     * @return true ou false si la requête est réussi ou non
     */
	public function get_sondages($login){
		$this->db->select('*')
			 ->from('sondage')
			 ->where('login',$login);
		$query = $this->db->get();
		if($query->num_rows()==0){
			return 0;
		}else if($query->num_rows()>=1){
			return $query ;
		} else
			return false;
	}

	/**
     * Récupere un sondage en particulier dans la base de donnée
     * @param $cle identificateur du sondage
     * @return true ou false si la requête est réussi ou non
     */
	public function get_sondage_cle($cle){
		$this->db->select('*')
			 ->from('sondage')
			 ->where('cle',$cle);
		$query = $this->db->get();
		if($query->num_rows()==1){
			return $query;
		} else
			return false;
	}
	
	/**
     * Mets à jour le sondage quand l'utilisateur le clôture
     * @param $cle identificateur du sondage
     */
	public function update_sondage($cle){
		$this->db->set('cloturer',true)
					->where('cle',$cle)
					->update('sondage');
	}

	/**
     * Supprime un sondage dans la base de donnée
     * @param $cle identificateur du sondage
     * @return la requête
     */
	public function delete_sondage($cle){
		$this->db->where('cle', $cle);
		$this->db->delete('vote');
		$this->db->where('cle', $cle);
		return ($this->db->delete('sondage'));
	}

	/**
     * Insert le vote d'un participant
     * @param $data ensemble de données nécessaires à l'insertion du tuple
     * @return la requête
     */
	public function update_vote($data){
		return	$this->db->insert('vote', $data);
	}

	/**
     * Vérifie si la même personne n'a pas déjà choisi le même horaire
     * @param $data ensemble de données nécessaires à la selection du tuple
     * @return true ou false si la requête est réussi ou non
     */
	public function verif_vote($data){
		$this->db->select('*')
				 ->from('vote')
				 ->where('cle',$data['cle'])
				 ->where('nom',$data['nom'])
				 ->where('code',$data['code']);
		$query = $this->db->get();
		if ($query->num_rows()==0)
			return true;
		else
			return false;
	}

	/**
     * Permets de récupérer les vote d'un sondage en particulier
     * @param $cleRecue identificateur du sondage
     * @return la requete
     */
	public function get_vote($cleRecue){
		$this->db->select('*')
			 ->from('vote')
			 ->where('cle',$cleRecue);
		$query = $this->db->get();
		return $query;
	}


}