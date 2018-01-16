<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//controllo su db se esiste già nella categoria scelta il numero di protocollo
//in caso negativo effettuare INSERT
// in caso positivo effettuare UPDATE
function check_DB($category, $nr_protocollo) {
    $nr_protocollo = trim($nr_protocollo);
    $category = trim($category);
    $query = pg_query(utf8_encode(''
                    . 'SELECT "numero protocollo generale" '
                    . 'FROM "' . $category . '"'
                    . 'WHERE "numero protocollo generale" =' . $nr_protocollo . ''));
    if (pg_num_rows($query) != 0) {
//funzione per UPDATE 
        return 1;
    } else {
//funzione per INSERT
        return 0;
    }
    return true;
}

function categoria_ordinanza($value) {
    $value = trim($value);
    $query_carico = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "carico scarico" WHERE "numero protocollo generale" =' . $value . ''));
    $query_cs2 = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "cs2" WHERE "numero protocollo generale" =' . $value . ''));
    $query_disabili_p = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "disabili giunta p" WHERE "numero protocollo generale" =' . $value . ''));
    $query_disabili_c = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "disabili giunta c" WHERE "numero protocollo generale" =' . $value . ''));
    $query_autocarri = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "divieto_autocarri_2000" WHERE "numero protocollo generale" =' . $value . ''));
    $query_dossi = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "dossi" WHERE "numero protocollo generale" =' . $value . ''));
    $query_bus = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "bus extraurbani" WHERE "numero protocollo generale" =' . $value . ''));
    $query_farmacia = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "farmacia 11" WHERE "numero protocollo generale" ='.$value.''));
    $query_ciclabili = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "piste_cicl" WHERE "numero protocollo generale" =' . $value . ''));
    $query_sensi = pg_query(utf8_encode('SELECT "numero protocollo generale" FROM "sensi" WHERE "numero protocollo generale" =' . $value . ''));
    //controllo quale quary sulle categorie è andata a buon fine
    if (pg_num_rows($query_carico)!= 0) {
        return 1;
    } elseif (pg_num_rows($query_cs2)!= 0) {
        return 2;
    } elseif (pg_num_rows($query_disabili_p)!= 0) {
        return 3;
    } elseif (pg_num_rows($query_disabili_c)!= 0) {
        return 4;
    } elseif (pg_num_rows($query_autocarri)!= 0) {
        return 5;
    } elseif (pg_num_rows($query_dossi)!= 0) {
        return 6;
    } elseif (pg_num_rows($query_bus)!= 0) {
        return 7;
    } elseif (pg_num_rows($query_farmacia)!= 0) {
        return 8;
    } elseif (pg_num_rows($query_ciclabili)!= 0) {
        return 9;
    } elseif (pg_num_rows($query_sensi)!= 0) {
        return 10;
    }
}
