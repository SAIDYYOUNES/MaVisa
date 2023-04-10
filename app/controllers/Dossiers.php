<?php
class Dossiers extends Controller
{
  private $dossierModel;

  public function __construct()
  {

    $this->dossierModel = $this->model('Dossier');
  }


  // Load All dossiers
  public function showAll()
  {
    header('Access-Control-Allow-Origin: *'); //public access
    header('Content-Type: application/json');
    $dossiers = $this->dossierModel->getdossiers();

    echo json_encode($dossiers);

  }

  // Show Single dossier
  public function show($id)
  {
    header('Access-Control-Allow-Origin: *'); //public access
    header('Content-Type: application/json');
    $dossier = array();
    $dossier = $this->dossierModel->getdossier($id);
    if (!empty($dossier)) {
      echo json_encode(
        array(
          'verify' => true,
          'data' => $dossier
        )
      );
    } else {
      echo json_encode(
        array(
          'message' => 'dossier doesnt existe',
          'verify' => false
        )
      );

    }
  }
  public function check($id)
  {
    header('Access-Control-Allow-Origin: *'); //public access
    header('Content-Type: application/json');
    $dossier = array();
    $dossier = $this->dossierModel->check($id);
    if (!empty($dossier)) {
      echo json_encode(
        array(
          'verify' => true,
          'data' => $dossier
        )
      );
    } else {
      echo json_encode(
        array(
          'message' => 'dossier doesnt existe',
          'verify' => false
        )
      );

    }
  }
  public function getrdv($date)
  {
    header('Access-Control-Allow-Origin: *'); //public access
    header('Content-Type: application/json');
    echo json_encode(
      array(
        // 'verify' => true,
        $this->dossierModel->getrdv($date)
      )
    );
    
  }
  public function getfulldays()
  {
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');
    
    echo json_encode(
      array(
      
        $this->dossierModel->fulldays()
      )
    );
    
  }
  public function verify($reff)
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    echo json_encode(
      array(

        $this->dossierModel->verify($reff)
      )
    );

  }

  // Add dossier
  public function add()
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $data = json_decode(file_get_contents("php://input"));
    $this->dossierModel->nom = $data->nom;
    $this->dossierModel->prenom = $data->prenom;
    $this->dossierModel->B_D = $data->date_naissance;
    $this->dossierModel->adresse = $data->adress;
    $this->dossierModel->nationalite = $data->nationalite;
    $this->dossierModel->situation_familiale = $data->situation_familiale;
    $this->dossierModel->type_de_visa = $data->type_visa;
    $this->dossierModel->date_de_depart = $data->date_depart;
    $this->dossierModel->date_d_arriver = $data->date_darrive;
    $this->dossierModel->type_de_documentdevoyage = $data->type_pass;
    $this->dossierModel->numerodedocumentdevoyage = $data->num_pass;
    $this->dossierModel->reff = bin2hex(random_bytes(strlen($data->num_pass)));
    // $token = bin2hex(random_bytes(strlen($data->num_pass)));

    if ($this->dossierModel->adddossier()) {
      echo json_encode(
        array(
          'message' => 'dossier added',
          'code' =>$this->dossierModel->reff
        )
      );
    } else {
      echo json_encode(
        array('message' => 'dossier Not added')
      );
    }

  }
  public function addrdv()
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $data = json_decode(file_get_contents("php://input"));
    $this->dossierModel->rdv = $data->date;
    $this->dossierModel->periode = $data->periode;
    $this->dossierModel->reff = $data->reff;
    // $this->dossierModel->p2 = $data->p2;
    // $this->dossierModel->p3 = $data->p3;
    // $this->dossierModel->p4 = $data->p4;
    // $this->dossierModel->situation_familiale = $data->situation_familiale;

    if ($this->dossierModel->addrdv()) {
      echo json_encode(
        array('message' => 'RDV added',
        )
      );
    } else {
      echo json_encode(
        array('message' => 'RDV Not added')
      );
    }
  }


  // // Edit dossier
  public function edit($id)
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    $data = json_decode(file_get_contents("php://input"));

    $this->dossierModel->id = $id;
    $this->dossierModel->nom = $data->nom;
    $this->dossierModel->prenom = $data->prenom;
    $this->dossierModel->B_D = $data->date_naissance;
    $this->dossierModel->adresse = $data->adress;
    $this->dossierModel->nationalite = $data->nationalite;
    $this->dossierModel->situation_familiale = $data->situation_familiale;
    $this->dossierModel->type_de_visa = $data->type_visa;
    $this->dossierModel->date_de_depart = $data->date_depart;
    $this->dossierModel->date_d_arriver = $data->date_darrive;
    $this->dossierModel->type_de_documentdevoyage = $data->type_pass;
    $this->dossierModel->numerodedocumentdevoyage = $data->num_pass;
    $this->dossierModel->reff = $data->reff;

    if ($this->dossierModel->updatedossier()) {
      echo json_encode(
        array('message' => 'dossier updated')
      );
    } else {
      echo json_encode(
        array('message' => 'dossier Not updated try later')
      );
    }



  }

  // Delete dossier
  public function delete($id)
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    $this->dossierModel->id = $id;

    if ($this->dossierModel->deletedossier()) {
      echo json_encode(
        array('message' => 'dossier deleted')
      );
    } else {
      echo json_encode(
        array('message' => 'dossier Not deleted')
      );
    }


  }
  public function deleterdv($id)
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    // $this->dossierModel->reff = $id;

    if ($this->dossierModel->deleterdv($id)) {
      echo json_encode(
        array('message' => 'rdv deleted')
      );
    } else {
      echo json_encode(
        array('message' => 'rdv Not deleted')
      );
    }


  }
}