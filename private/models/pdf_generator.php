<?php

include("../../private/package/fpdf/fpdf.php");
class PDFGenerator extends FPDF
{
 // En-tête
 function HeaderPDF(
  $date_demande,
 ) {
  $this->Image("C:/xampp/htdocs/gestion_edf/private/models/header.png", 0, 0, 210, 60, "PNG");
  $this->Ln(55);
  $this->SetFont('Times', '', 20);
  $this->Cell(80);
  $this->Cell(30, 10, 'DEMANDE DE BRANCHEMENT ELECTRIQUE', 0, 0, 'C');
  $this->Ln(8);
  $this->SetFont('Times', '', 15);
  $this->Cell(200, 10, 'Date de la demande : ' . $date_demande, 0, 0, 'C');
 
 }

 public function bodyPDF(
  $date_demande,
  $nom_client,
  $prenom_client,
  $telephone_client,
  $adresse_client,
  $rue_travaux,
  $nom_lotissement,
  $commune_travaux,
  $type_branchement,
  $maitre_oeuvre,
  $electricien,
  $ref_dossier,
  $zei

 ) {

  $pdf = new PDFGenerator();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->HeaderPDF(
   $date_demande,
   $nom_client,
   $prenom_client,
   $telephone_client,
   $adresse_client,
   $rue_travaux,
   $nom_lotissement,
   $commune_travaux,
   $type_branchement,
   $maitre_oeuvre,
   $electricien,
   $ref_dossier,
   $zei

  );
  
  $pdf->SetFillColor(255, 165, 0);
  $pdf->Ln(20);
  $pdf->Cell(60,  10, "REFERENCE DOSSIER", 1, 0, 'l');
  $pdf->Cell(30,  10, $ref_dossier, 1, 0, 'C');
  $pdf->Cell(50,  10, "ZEI de rattachement", 1, 0, 'L');
  $pdf->Cell(30,  10, $zei['VILLE_ZEI'], 1, 0, 'C');
  $pdf->Ln(10);

  $pdf->Cell(60,  20, "NOM : " . $nom_client, 0, 0, 'l');
  $pdf->Cell(30,  20, "", 0, 0, 'C');
  $pdf->Cell(50,  20, "PRENOM:", 0, 0, 'L');
  $pdf->Cell(30,  20, $prenom_client, 0, 0, 'C');

  $pdf->Ln(15);

  $pdf->Cell(170,  8, "COORDONNEES ACTUELLES", 1, 0, 'l', true);
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "ADRESSE :" . $adresse_client, 1, 0, 'l');

  $pdf->Ln(8);
  $pdf->Cell(170,  8, "TEL :" . $telephone_client, 1, 0, 'l');

  $pdf->Ln(15);


  $pdf->Cell(170,  8, "ADRESSE DES TRAVAUX", 1, 0, 'l', true);
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "RUE :" . $rue_travaux, 1, 0, 'l');
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "NOM LOTISSEMENT :" . $nom_lotissement, 1, 0, 'l');
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "COMMUNUE :" . $commune_travaux, 1, 0, 'l');


  $pdf->Ln(15);

  $pdf->Cell(170,  8, "TYPE DE LA DEMANDE", 1, 0, 'l', true);
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "TYPE : " . $type_branchement, 1, 0, 'l');


  $pdf->Ln(15);

  $pdf->Cell(170,  8, "COORDONNEES DES PROFESSIONNELS QUI VOUS ACCOMPAGNER", 0, 0, 'C');
  $pdf->Ln(12);
  $pdf->Cell(170,  8, "VOTRE ELECTRICIEN", 0, 0, 'C', true);
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "ADRESSE : " . $electricien['NOM_ELECTRICIEN'], 1, 0, 'l');
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "TEL : " . $electricien['ADRESSE_ELECTRICIEN'], 1, 0, 'l');
  $pdf->Ln(16);
  $pdf->Cell(170,  8, "VOTRE MAITRE D'OEUVRE ", 0, 0, 'C', true);
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "ADRESSE : " . $maitre_oeuvre['NOM_MAITRE_OEUVRE'], 1, 0, 'l');
  $pdf->Ln(8);
  $pdf->Cell(170,  8, "TEL : " . $maitre_oeuvre['ADRESSE_MAITRE_OEUVRE'], 1, 0, 'l');


  $pdf->Output("", "DEMANDE-BRACHEMENT DU "   . date('D. d M. Y H:i') . '.pdf', true);
 }
}
