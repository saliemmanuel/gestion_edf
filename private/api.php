<?php
include "connexiondb.php";
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
        $_SESSION['nom_lotissement'] = $nom;
        $_SESSION['rue_lotissement'] = $rue;
        $_SESSION['commune_lotissement'] = $commune;
        header('location:page_devis.php');
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
            $resultat_select_contract = $data_contract->execute();
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
        }
    }

    public function getListZEI()
    {
        $bdd = connexionDb();
        $sql = 'SELECT * FROM `zei`';
        $da = $bdd->query($sql);
        $list_zei = $da->fetchAll();
        return $list_zei;
    }
}
