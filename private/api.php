<?php
include "connexiondb.php";
include "models/pdf_generator.php";
// @autor 
// SALI EMMANUEL
// Tel : 698066896
// github : github.com/saliemmanuel

class API
{

    public function redirectionPageDemandeBranchement()
    {
        // recuperation des informations de l'utilisateur
        $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
        $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
        $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : "";
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['telephone'] = $telephone;
        header('location:demande_branchement.php');
    }

    public function redirectionPageDevis()
    {
        // recuperation des informations propre au lotissement
        $nom = isset($_POST['nom_lotissement']) ? $_POST['nom_lotissement'] : "";
        $rue = isset($_POST['rue_lotissement']) ? $_POST['rue_lotissement'] : "";
        $commune = isset($_POST['commune_lotissement']) ? $_POST['commune_lotissement'] : "";
        $type_branchement = isset($_POST['type_branchement']) ? $_POST['type_branchement'] : "";

        $_SESSION['nom_lotissement'] = $nom;
        $_SESSION['rue_lotissement'] = $rue;
        $_SESSION['commune_lotissement'] = $commune;
        $_SESSION['type_branchement'] = $type_branchement;
        header('location:page_devis.php');
    }

    public function redirectionPageSelectionZEI()
    {
        // recuperation des informations propre au lotissement
        $montant = isset($_POST['montant']) ? $_POST['montant'] : "";
        $date = isset($_POST['date']) ? $_POST['date'] : "";

        $_SESSION['montant'] = $montant;
        $_SESSION['date'] = $date;
        header('location:selection_zei.php');
    }

    public function insertionSousTraitant($code_sous_traitant)
    {

        // information proppre au sous traitant
        $bdd = connexionDb();
        $nom_sous_traitant = isset($_POST['nom_sous_traitant']) ? $_POST['nom_sous_traitant'] : "";
        $telephone_sous_traitant = isset($_POST['telephone_sous_traitant']) ? $_POST['nom_sous_traitant'] : "";
        $id_zei = isset($_POST['zei']) ? $_POST['zei'] : "";

        // Information propre au contract
        $code_contract = rand(100000000, 999999999);
        $nom_contract = "CT-" . $nom_sous_traitant;

        // insertion dans la table sous traitant
        $sql = 'INSERT INTO `sous_traitant`( 
        `CODE_SOUS_TRAITANT`, `NOM_SOUS_TRAITANT`, 
        `ADRESSE_SOUS_TRAITANT`) 
        VALUES ("' . $code_sous_traitant . '","' . $nom_sous_traitant . '",
        "' . $telephone_sous_traitant . '")';
        $data = $bdd->prepare($sql);
        $resultat = $data->execute();
        if ($resultat) {
            // recuperation de l'id du sous traitant
            $sql_select = 'SELECT * FROM `sous_traitant` 
            WHERE `CODE_SOUS_TRAITANT` = "' . $code_sous_traitant . '"';
            $data = $bdd->prepare($sql_select);
            $data->execute();
            $val = $data->fetch();
            $id_sous_traitant = $val['ID_SOUS_TRAITANT'];

            // insertion dans la table contract
            $sql_contract = 'INSERT INTO `contrat` 
            (`CODE_CONTRACT`, `NOM_CONTRACT`, `ID_SOUS_TRAITANT`) 
            VALUES ("' . $code_contract . '","' . $nom_contract . '",
            "' . $id_sous_traitant . '")';
            $data_contract = $bdd->prepare($sql_contract);
            $data_contract->execute();

            // recuperation de l'id du contract
            $sql_select_contract = 'SELECT * FROM `contrat` 
            WHERE `CODE_CONTRACT` = "' . $code_contract . '"';
            $data_contract = $bdd->prepare($sql_select_contract);
            $data_contract->execute();
            $val_contract = $data_contract->fetch();
            $id_contract = $val_contract['ID_CONTRAT'];

            // recuperation des jours de travail
            $jours = "";
            if (isset($_POST['jour'])) {
                $couleursSelectionnees = $_POST['jour'];
                foreach ($couleursSelectionnees as $couleur) {
                    $jours .= "," . $couleur;
                }
            }

            // insertion des jours de travail du sous traitant
            $sql_jours = 'INSERT INTO `jour` 
            (`JOUR`) 
            VALUES ("' . $jours . '")';
            $data_jours = $bdd->prepare($sql_jours);
            $data_jours->execute();

            // recuperation du dernier id de jour
            $sql_select_last_id_jour = 'SELECT MAX(ID_JOUR) AS LAST_ID_JOUR FROM `jour`';
            $data_last_id_jour = $bdd->prepare($sql_select_last_id_jour);
            $data_last_id_jour->execute();
            $val_last_id_jour = $data_last_id_jour->fetch();
            $id_jour = $val_last_id_jour['LAST_ID_JOUR'];

            // insertion dans la table signer 
            $sql_signer = 'INSERT INTO `signer`
            (`ID_CONTRAT`, `ID_JOUR`, `ID_ZEI`) 
            VALUES ("' . $id_contract . '","' . $id_jour . '","' . $id_zei . '")';
            $data_signer = $bdd->prepare($sql_signer);
            $data_signer->execute();

            $_SESSION['success_sous_traitant'] = "Le sous-traitant a bien été enregistré";
        }
    }

    // recapitulatif dossier demande branchement
    public function redirectionPagerecapitulatif($electricien, $maitre_oeuvre)
    {
        $_SESSION['electricien'] = $electricien;
        $_SESSION['maitre_oeuvre'] = $maitre_oeuvre;
        $_SESSION['zei'] = $_POST['zei'];
        header("location:recapitulatif_demande.php");
    }

    // insertion dans la table demande
    public function insertDemande($ref_dossier, $id_zei)
    {
        $bdd = connexionDb();

        $reference = $ref_dossier;
        $date_demande = date('Y-m-d');
        $nom_client = $_SESSION['nom'];
        $prenom_client = $_SESSION['prenom'];
        $telephone_client = $_SESSION['telephone'];
        $adresse_client = $_SESSION['nom_lotissement'];
        $rue_travaux = $_SESSION['rue_lotissement'];
        $nom_lotissement = $_SESSION['nom_lotissement'];
        $commune_travaux = $_SESSION['commune_lotissement'];
        $type_branchement = $_SESSION['type_branchement'];
        $id_maitre_oeuvre = $_SESSION['maitre_oeuvre']['ID_MAITRE_OEUVRE'];
        $id_electricien = $_SESSION['electricien']['ID_ELECTRICIEN'];

        // Insertion du client dans la table client et récupération de son ID
        $sql_insert_client = 'INSERT INTO `client` 
       (`NOM_CLIENT`, `PRENOM_CLIENT`, `TEL_CLIENT`, `ADRESSE_CLIENT`) 
       VALUES ("' . $nom_client . '","' . $prenom_client . '",
       "' . $telephone_client . '","' . $adresse_client . '")';
        $data_insert_client = $bdd->prepare($sql_insert_client);
        $data_insert_client->execute();
        $id_client = $bdd->lastInsertId();

        // insertion du lotissement dans la table lotissement et récupération de son ID
        // INSERT INTO `lotissement`(`ID_LOTISSEMENT`, `NOM_LOTISSEMENT`, `RUE_LOTISSEMENT`, `COMMUNE_LOTISSEMENT`, `ID_ELECTRICIEN`, `ID_MAITRE_OEUVRE`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
        $sql_insert_lotissement = 'INSERT INTO `lotissement`
       (`NOM_LOTISSEMENT`, `RUE_LOTISSEMENT`, `COMMUNE_LOTISSEMENT`,
       `ID_ELECTRICIEN`, `ID_MAITRE_OEUVRE`)
       VALUES ("' . $nom_lotissement . '","' . $rue_travaux . '",
       "' . $commune_travaux . '","' . $id_electricien . '",
       "' . $id_maitre_oeuvre . '")';
        $data_insert_lotissance = $bdd->prepare($sql_insert_lotissement);
        $data_insert_lotissance->execute();
        $id_lotissement = $bdd->lastInsertId();


        // insertion dans la table demande
        $sql = 'INSERT INTO `demande` 
        (`REFERENCE_DEMANDE`, `DATE_DEMANDE`,
        `NOM_CLIENT_DEMANDE`, `PRENOM_CLIENT_DEMANDE`,
        `ADRESSE_CLIENT_DEMANDE`, `TEL_CLIENT_DEMANDE`,
        `TYPE_BRANCHEMENT`,
        `RUE_TRAVAUX_DEMANDE`, `NOM_LOTISSEMENT_DEMANDE`,
        `COMMUNE_TRAVAUX_DEMANDE`, `ID_CLIENT`,
        `ID_LOTISSEMENT`, `ID_ZEI`)
        VALUES ("' . $reference . '","' . $date_demande . '",
        "' . $nom_client . '","' . $prenom_client . '",
        "' . $adresse_client . '","' . $telephone_client . '",
        "' . $type_branchement . '",
        "' . $rue_travaux . '","' . $nom_lotissement . '",
        "' . $commune_travaux . '","' . $id_client . '",
        "' . $id_lotissement . '","' . $id_zei . '")';
        $data_insert_demande = $bdd->prepare($sql);
        $data_insert_demande->execute();
        // recuperer id demande
        $id_demande = $bdd->lastInsertId();
        $_SESSION['success'] = "La demande a bien été enregistrée";
        $_SESSION['id_demande'] = $id_demande;
    }

    // selection demande par id et 
    public function donwloadPDF(
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
        $pdf->bodyPDF(
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
    }

    public function getListZEI()
    {
        $bdd = connexionDb();
        $sql = 'SELECT * FROM `zei`';
        $da = $bdd->query($sql);
        $list_zei = $da->fetchAll();
        return $list_zei;
    }

    // selection zei par id et renvoie un tableau
    public function selectZEIById($id)
    {
        $bdd = connexionDb();
        $sql = 'SELECT * FROM `zei` WHERE `ID_ZEI` = ' . $id;
        $da = $bdd->query($sql);
        $zei = $da->fetch();
        return $zei;
    }

    // selection electricien au hasard
    public function selectRandomElectrician()
    {
        $bdd = connexionDb();
        $sql = 'SELECT * FROM `electricien` ORDER BY RAND() LIMIT 1';
        $da = $bdd->query($sql);
        $electrician = $da->fetch();
        return $electrician;
    }

    // selection maitre oeuvre au hasard
    public function selectRandomMaitreOeuvre()
    {
        $bdd = connexionDb();
        $sql = 'SELECT * FROM `maitre_oeuvre` ORDER BY RAND() LIMIT 1';
        $da = $bdd->query($sql);
        $masterBuilder = $da->fetch();
        return $masterBuilder;
    }

    // selection tous les demande des clients 
    public function selectAllDemande()
    {
        $bdd = connexionDb();
        $sql = 'SELECT * FROM `demande`';
        $da = $bdd->query($sql);
        $demande = $da->fetchAll();
        return $demande;
    }

    // selection des electriciens ayant pour maitre oeuvre "zozo"
    public function selectElectriciansByMasterBuilder()
    {
        $bdd = connexionDb();
        $sql = 'SELECT DISTINCT lotissement.*, maitre_oeuvre.*, electricien.*
        FROM lotissement
        JOIN maitre_oeuvre ON maitre_oeuvre.ID_MAITRE_OEUVRE = lotissement.ID_MAITRE_OEUVRE
        JOIN electricien ON electricien.ID_ELECTRICIEN = lotissement.ID_ELECTRICIEN
        WHERE maitre_oeuvre.NOM_MAITRE_OEUVRE = \'zozo\'';
        $da = $bdd->query($sql);
        $electricians = $da->fetchAll();
        return $electricians;
    }

    // 
}
