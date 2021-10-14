<?php
$config=[
	'Utilisateur/inscription' =>[
		[
			'field' => 'nom',
			'label' => 'Nom',
			'rules' => 'required|trim|max_length[30]',

			'errors' => [
				'required'=>'{field} est requis',
				'trim'=>'{field} ne doit pas comporter d\'espaces',
				'max_length'=>' {field} ne doit pas dépasser les 30 caractères !'
			]
		],
		[
			'field' => 'prenom',
			'label' => 'Prénom',
			'rules' => 'required|trim|max_length[30]',

			'errors' => [
				'required'=>'{field} est requis',
				'trim'=>'{field} ne doit pas comporter d\'espaces',
				'max_length'=>' {field} ne doit pas dépasser les 30 caractères !'
			]
		],
		[
			'field' => 'login',
			'label' => 'Login',
			'rules' => 'is_unique[utilisateur.login]|max_length[30]',
			
			'errors' => [
				'is_unique'=>'{field} est déjà présent dans la base.',
				'max_length'=>' {field} ne doit pas dépasser les 30 caractères !'
			]
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'valid_email|is_unique[utilisateur.email]|max_length[100]',
			
			'errors' => [
				'valid_email'=>'{field} n\'est pas valide',
				'max_length'=>' {field} ne doit pas dépasser les 100 caractères !'
			]
		],
		[
			'field' => 'mdp',
			'label' => 'Mot de passe',
			'rules' => 'required',

			'errors' => [
				'required'=>'{field} est requis'
			]
		],
		[
			'field' => 'mdp2',
			'label' => 'Mot de passe de vérification',
			'rules' => 'matches[mdp]',

			'errors' => [
				'matches'=>'Le {field} doit correspondre au mot de passe'
			]
		]
	],

	'Utilisateur/connexion' =>[
		[
			'field' => 'login',
			'label' => 'Login',
			'rules' => 'required|max_length[30]',

			'errors' => [
				'required'=>'{field} est requis',
				'max_length'=>' {field} ne doit pas dépasser les 30 caractères !'
			]
		],
		[
			'field' => 'mdp',
			'label' => 'Mot de passe',
			'rules' => 'required',

			'errors' => [
				'required'=>'{field} est requis'
			]
		]
	],

	'Utilisateur/sondage1' =>[
		[
			'field' => 'titre',
			'label' => 'Titre',
			'rules' => 'required|max_length[50]',

			'errors' => [
				'required' => '{field} est requis',
				'max_length'=>'Le {field} ne doit pas dépasser les 50 caractères !'
			]
		],
		[
			'field' => 'lieu',
			'label' => 'Lieu',
			'rules' => ''
		],
		[
			'field' => 'note',
			'label' => 'Note',
			'rules' => 'max_length[100]',

			'errors' => [
				'max_length'=>' {field} ne doit pas dépasser les 100 caractères !'
			]
		]
	],
	'Utilisateur/sondage2' =>[
		[
			'field' => 'dateDebut',
			'label' => 'Date de début',
			'rules' => 'required',

			'errors' => [
				'required' => '{field} est requis',
			]
		],
		[
			'field' => 'dateFin',
			'label' => 'Date de fin',
			'rules' => 'required',

			'errors' => [
				'required' => '{field} est requis',
			]
		]
	],
	'Utilisateur/sondage3' =>[
		[
			'field' => 'heureDebut',
			'label' => 'Heure de debut',
			'rules' => 'required',

			'errors' => [
				'required' => '{field} est requis'
			]
		],
		[
			'field' => 'heureFin',
			'label' => 'Heure de fin',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} est requis',
			]
		]
	],
	'Utilisateur/sondage4' =>[
		[
			'field' => 'nom',
			'label' => 'Nom',
			'rules' => 'required|max_length[30]',

			'errors' => [
				'required' => '{field} est requis',
				'max_length'=>' {field} ne doit pas dépasser les 30 caractères !'
			]
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'valid_email|required|max_length[100]',
			'errors' => [
				'required' => '{field} est requis',
				'max_length'=>' {field} ne doit pas dépasser les 100 caractères !'
			]
		]
	],
	'Utilisateur/vote' =>[
		[
			'field' => 'login',
			'label' => 'Login',
			'rules' => 'required|max_length[20]',

			'errors' => [
				'required' => '{field} est requis',
				'max_length'=>' {field} ne doit pas dépasser les 20 caractères !'
			]
		],
		[
			'field' => 'code',
			'label' => 'Case à cocher',
			'rules' => 'required',
			'errors' => [
				'required' => 'Au moins une {field} est requise'
			]
		]
	]
]
?>