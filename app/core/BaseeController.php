<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseeController extends CI_Controller {

    protected $session;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // Charge la bibliothèque de session
        $this->session->start(); // Démarrer manuellement les sessions
    }

    protected function authenticate() {
        // Vérifier si l'utilisateur est authentifié
        if (!$this->session->userdata('logged_in')) {
            // Ou vous pouvez retourner une erreur JSON si c'est une API REST
            $this->output->set_output(json_encode(['error' => 'Unauthorized']));
            // Exemple : $this->output->set_status_header(401);

            // Arrête l'exécution de la fonction si l'utilisateur n'est pas authentifié
            exit;
        }
    }
}
