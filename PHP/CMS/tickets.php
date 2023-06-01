<?php
    include("config.php");
    switch($_GET["act"]){
        case "new":
            if(empty($_POST)){
                echo form(
                        textarea("problema", "problema", "tutto a posto!").
                        input("creazione", "creazione", "", "datetime-local").
                        lista("idcategoria", "idcategoria", "categoria", "tkt_categorie").
                        lista("idstato", "idstato", "stato", "tkt_statiticket"),
                    false, "salva");
            } else {
                $idutente = 1;
                $creazione = str_replace("T", " ", $_POST["creazione"]);
                EseguiDB("INSERT INTO tkt_tickets (idutente, ticket, creazione, idcategoria, idstato)
                                            VALUES (".$idutente.", '".addslashes($_POST["problema"])."', '".addslashes($creazione)."', ".intval($_POST["idcategoria"]).", ".intval($_POST["idstato"]).")");
                header("location: tickets.php");
            }
            break;
            
        case "del":
            EseguiDB("DELETE FROM tkt_tickets WHERE idticket=".intval($_GET["id"])." LIMIT 1;");
            header("location: tickets.php");
            break;
            
        default:
            echo tabella("SELECT tkt_tickets.creazione, tkt_tickets.idticket, tkt_tickets.ticket, 
                                tkt_categorie.categoria, tkt_statiticket.stato,
                                concat(tkt_utenti.nome, ' ', tkt_utenti.cognome) as utente 
                                FROM tkt_tickets 
                                LEFT JOIN tkt_utenti on tkt_tickets.idutente=tkt_utenti.idutente 
                                LEFt JOIN tkt_categorie on tkt_tickets.idcategoria=tkt_categorie.idcategoria 
                                LEFt JOIN tkt_statiticket on tkt_tickets.idstato=tkt_statiticket.idstato 
                                ORDER BY tkt_tickets.creazione desc;",
                                "idticket");
            break;
    }