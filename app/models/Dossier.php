<?php
class dossier
{
  private $db;

  public $nom;
  public $prenom;
  public $B_D;
  public $nationalite;
  public $situation_familiale;
  public $adresse;
  public $type_de_visa;
  public $date_de_depart;
  public $date_d_arriver;
  public $type_de_documentdevoyage;
  public $numerodedocumentdevoyage;
  public $reff;
  public $id;
  public $rdv;
  public $periode;
  // public $p2;
  // public $p3;
  // public $p4;
  public function __construct()
  {
    $this->db = new Database;
  }

  // Get All dossiers
  public function getdossiers()
  {
    $this->db->query("SELECT *
                        FROM clients
                        
                        
                        ;");

    $results = $this->db->resultset();

    return $results;
  }

  // Get dossier By ID
  public function getdossier($id)
  {
    $this->db->query("SELECT * FROM `clients`join randezvous on clients.reff=randezvous.reff where clients.reff= :id");

    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }
  public function check($id)
  {
    $this->db->query("SELECT * FROM clients WHERE reff = :id");

    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }

  // Add dossier
  public function adddossier()
  {

    $this->db->query("INSERT INTO clients (reff,nom,prenom,date_naissance,situation_familiale,adress,date_depart,date_darrive,type_pass,num_pass,type_visa,nationalite) VALUES
    (:reff,:nom,:prenom,:B_D,:situation_familiale,:adress,:date_depart,:date_darrive,:type_pass,:num_pass,:type_visa,:nationalite)");


    // Bind Values
    $this->db->bind(':nom', $this->nom);
    $this->db->bind(':prenom', $this->prenom);
    $this->db->bind(':B_D', $this->B_D);
    $this->db->bind(':nationalite', $this->nationalite);
    $this->db->bind(':situation_familiale', $this->situation_familiale);
    $this->db->bind(':adress', $this->adresse);
    $this->db->bind(':type_visa', $this->type_de_visa);
    $this->db->bind(':date_depart', $this->date_de_depart);
    $this->db->bind(':date_darrive', $this->date_d_arriver);
    $this->db->bind(':type_pass', $this->type_de_documentdevoyage);
    $this->db->bind(':num_pass', $this->numerodedocumentdevoyage);
    $this->db->bind(':reff', $this->reff);

    //Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }

  }
  public function deleterdv($id)
  {
    // Prepare Query
    $this->db->query('DELETE FROM randezvous WHERE reff = :id');

    // Bind Values
    $this->db->bind(':id', $id);
    // $this->db->bind(':id', $id);

    //Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function addrdv()
  {
    $this->db->query("INSERT INTO randezvous(
      
        RDV,".$this->periode.",reff)
     VALUES
     (:rdv ,:true ,:reff)");


    // Bind Values
    $this->db->bind(':rdv', $this->rdv);
    // $this->db->bind(':periode', $this->periode);
    $this->db->bind(':true', true);
    $this->db->bind(':reff', $this->reff);
    
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function verify($reff)
  {
    $this->db->query("SELECT EXISTS(SELECT * from randezvous WHERE reff =:reff) as verify");

    $this->db->bind(':reff', $reff);
    $result = $this->db->single();

    return $result;
    
  }
  public function updatedossier()
  {

    $this->db->query("UPDATE clients SET 
    reff = :reff,
    nom = :nom,
    prenom= :prenom,
    date_naissance = :B_D,
    situation_familiale = :situation_familiale,
    adress = :adress,
    date_depart = :date_depart,
    date_darrive = :date_darrive,
    type_pass = :type_pass,
    num_pass = :num_pass,
    type_visa = :type_visa,
    nationalite = :nationalite 
    where id = :id ");

    // Bind Values
    $this->db->bind(':nom', $this->nom);
    $this->db->bind(':prenom', $this->prenom);
    $this->db->bind(':B_D', $this->B_D);
    $this->db->bind(':nationalite', $this->nationalite);
    $this->db->bind(':situation_familiale', $this->situation_familiale);
    $this->db->bind(':adress', $this->adresse);
    $this->db->bind(':type_visa', $this->type_de_visa);
    $this->db->bind(':date_depart', $this->date_de_depart);
    $this->db->bind(':date_darrive', $this->date_d_arriver);
    $this->db->bind(':type_pass', $this->type_de_documentdevoyage);
    $this->db->bind(':num_pass', $this->numerodedocumentdevoyage);
    $this->db->bind(':reff', $this->reff);
    $this->db->bind(':id', $this->id);

    //Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Update dossier


  // Delete dossier
  public function deletedossier()
  {
    // Prepare Query
    $this->db->query('DELETE FROM clients WHERE id = :id');

    // Bind Values
    $this->db->bind(':id', $this->id);
    // $this->db->bind(':id', $id);

    //Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function getrdv($date){
    $this->db->query('
    SELECT rdv, MAX(p1) AS p1,  MAX(p2)as p2 , MAX(p3) AS p3,  MAX(p4) AS p4
FROM randezvous
WHERE RDV =:rdv
GROUP BY RDV');

    // Bind Values
    $this->db->bind(':rdv', $date);
    $result = $this->db->single();

    return $result;

  }
  public function fulldays(){
    $this->db->query('SELECT RDV FROM randezvous GROUP BY RDV HAVING COUNT(*) = 4');

    $result = $this->db->resultset();

    return $result;

  }
}