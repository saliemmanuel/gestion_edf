<?php

// @autor 
// SALI EMMANUEL
// Tel : 698066896
// github : github.com/saliemmanuel

require_once('include.php');

// classe gestion des services de l'api
class Navigator
{
    public function getApi($service)
    {
        $bdd = connexionDb();
        $api  = new API();
        if (empty($service))
            echo $api->errorService();
        else
            switch ($service) {

                case 'inscription':
                    echo $api->inscription($bdd);
                    break;
                case 'connexion':
                    echo $api->connexion($bdd);
                    break;
                case 'annonce':
                    echo $api->getAnnonce($bdd);
                    break;
                case 'publication':
                    echo $api->getPublication($bdd);
                    break;
                case 'getclient':
                    echo $api->getClientInf($bdd);
                    break;
                case 'getPubForPres':
                    echo $api->getPubForPresta($bdd);
                    break;
                case 'getPubForClient':
                    echo $api->getPubForClient($bdd);
                    break;
                case 'putAnn':
                    echo $api->putAnn($bdd);
                    break;
                case 'putPub':
                    echo $api->putPub($bdd);
                    break;
                case 'getPresInfo':
                    echo $api->getPresInf($bdd);
                    break;
                case 'getDiscution':
                    echo $api->getDiscution($bdd);
                    break;
                case 'getConversation':
                    echo $api->getConversation($bdd);
                    break;
                case 'sendMessage':
                    echo $api->sendMessage($bdd);
                    break;
                default:
                    echo $api->serviceInconnu();
                    break;
            }
    }
}
