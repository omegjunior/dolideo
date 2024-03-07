<?php
/* Copyright (C) 2024-2027  Frédéric H Omega Junior <omegajunior.apps@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file        custom/dolidolideo/class/lettrage_dolideo.php
 * \ingroup     Module Dolidolideo
 * \brief       File to manage lettrage numerotation
 */

function getNumPiecedolideo($objectbookkeeping)
{
    dol_syslog('Enter into getNumPiecedolideo');
    global $db, $user;  // Assurez-vous que la connexion à la base de données est accessible

    try {
        // par précaution mettre entity sur entity de la configuration courante si bookkeeping n'en a pas
        $entityofobject = !empty($objectbookkeeping->entity)? $db->escape($objectbookkeeping->entity) : $conf->entity;
        dol_syslog('Enter into confentity '.$conf->entity);
        dol_syslog('Enter into confentityofobject '.$entityofobject);
        dol_syslog('Enter into confentityofobjectbook '.$objectbookkeeping->entity);
        // le numéro au compteur
        $sqllettrage  = "SELECT ct.compteur, ct.num_transa_precedent";
        $sqllettrage .= " FROM ".MAIN_DB_PREFIX."dolideo_compteur_transaction as ct";
        $sqllettrage .= " WHERE ct.mois = ".(str_pad(date('m', $objectbookkeeping->doc_date), 2, '0', STR_PAD_LEFT));
        $sqllettrage .= " AND ct.annee = ".(substr(date('Y', $objectbookkeeping->doc_date), -2));
        $sqllettrage .= " AND ct.journal = '".$objectbookkeeping->code_journal."'";
        $sqllettrage .= " AND entity = '".$entityofobject."'";
        $resqllettrage = $db->query($sqllettrage);
        //dol_print_error($db);
        if ($resqllettrage) {
            //dol_syslog('fred book enter1');
            $objlettrage = $db->fetch_object($resqllettrage);
            if (empty($objlettrage->compteur)){
                $numpiecedolideo = (str_pad(date('m', $objectbookkeeping->doc_date), 2, '0', STR_PAD_LEFT)).(substr(date('Y', $objectbookkeeping->doc_date), -2)).$objectbookkeeping->code_journal.'1';

                // insérer dans compteur comme précédent
                $sqllettrage  = "INSERT INTO ".MAIN_DB_PREFIX."dolideo_compteur_transaction";
                $sqllettrage .= "(mois,annee,journal,compteur,num_transa_precedent, entity, fk_user_creat)";
                $sqllettrage .= " VALUES('".(str_pad(date('m', $objectbookkeeping->doc_date), 2, '0', STR_PAD_LEFT))."', '".(substr(date('Y', $objectbookkeeping->doc_date), -2))."', '".$objectbookkeeping->code_journal;
                $sqllettrage .= "', 2, ".$objectbookkeeping->piece_num.", ".$entityofobject.", ".$user->id.")";
                $resqllettrage = $db->query($sqllettrage);
            } elseif($objectbookkeeping->piece_num == $objlettrage->num_transa_precedent){
                $numpiecedolideo = (str_pad(date('m', $objectbookkeeping->doc_date), 2, '0', STR_PAD_LEFT)).(substr(date('Y', $objectbookkeeping->doc_date), -2)).$objectbookkeeping->code_journal.($objlettrage->compteur-1);
            } else {
                $numpiecedolideo = (str_pad(date('m', $objectbookkeeping->doc_date), 2, '0', STR_PAD_LEFT)).(substr(date('Y', $objectbookkeeping->doc_date), -2)).$objectbookkeeping->code_journal.$objlettrage->compteur;

                //mise à jour du compteur
                //dol_syslog('compteur evolution '.$objlettrage->compteur.' et '.($objlettrage->compteur+1));
                $sqllettrage  = "UPDATE ".MAIN_DB_PREFIX."dolideo_compteur_transaction SET ";
                $sqllettrage .= "compteur = "."'".($objlettrage->compteur+1)."'";
                $sqllettrage .= ", num_transa_precedent = "."'".($objectbookkeeping->piece_num)."'";	
                $sqllettrage .= " WHERE mois = '".(str_pad(date('m', $objectbookkeeping->doc_date), 2, '0', STR_PAD_LEFT));
                $sqllettrage .= "' AND annee = '".(substr(date('Y', $objectbookkeeping->doc_date), -2));
                $sqllettrage .= "' AND journal = '".$objectbookkeeping->code_journal;
                $sqllettrage .= "' AND entity = '".$entityofobject."'";
                $resqllettrage = $db->query($sqllettrage);
            }
        }
        return $numpiecedolideo;

    } catch (Exception $e) {
        // Gérez l'erreur ici, par exemple, journalisez-la
        dol_syslog('Erreur à l\'insertion dans compteur transaction');
        return false;
    }
}




function deleteNumPiecedolideo($objectbookkeeping)
{
    global $db, $conf;  // Assurez-vous que la connexion à la base de données est accessible

    try {
        //charger les extrafields de l'objet
		$objectbookkeeping->fetch_optionals();
        //mise à jour du compteur
        $sqllettrage  = "UPDATE ".MAIN_DB_PREFIX."dolideo_compteur_transaction SET ";
        $sqllettrage .= "compteur = (compteur - 1)";	
        $sqllettrage .= " WHERE mois = '".(str_pad(date('m', $objectbookkeeping->doc_date), 2, '0', STR_PAD_LEFT));
        $sqllettrage .= "' AND annee = '".(substr(date('Y', $objectbookkeeping->doc_date), -2));
        $sqllettrage .= "' AND journal = '".$objectbookkeeping->code_journal;
        $sqllettrage .= "' AND entity = ".$conf->entity;
        $resqllettrage = $db->query($sqllettrage); 
        // suppression dans table extrafields de bookkeeping
        $objectbookkeeping->deleteExtraFields();
        //suppression des doubles parties dans l'extrafields
        $sqllettrage  = "DELETE FROM ".MAIN_DB_PREFIX."accounting_bookkeeping_extrafields ";
        $sqllettrage .= " WHERE numpiecedolideo = '".$objectbookkeeping->array_options['options_numpiecedolideo']."'";       
        $resqllettrage = $db->query($sqllettrage); 
        return true;
    } catch (Exception $e) {
        // Gérez l'erreur ici, par exemple, journalisez-la
        dol_syslog('Erreur à l\'insertion dans compteur transaction');
        return false;
    }
}