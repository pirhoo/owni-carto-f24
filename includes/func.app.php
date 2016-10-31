<?php

    // Nous plaçons cette condition au début de chaque includes
    // elle garanti l'inclusion depuis les fichiers autorisés
    // (fichiers qui définissent la constante avec la bonne valeur)
    if(SAFE_PLACE != "FD622N18U8h7y4Xs76cO80QX5AfOWkvg") die();
    
    function generateDB() {

        /* @var $e ErrorsLog */
        /* @var $database dbMySQL */
        global $e, $database;

        if( isset($_FILES["csv_file"]) ) {

            // il y a-t-il des erreurs de transfert ?
            if ($_FILES['csv_file']['error']) {
                switch ($_FILES['csv_file']['error']){

                    case 1: // UPLOAD_ERR_INI_SIZE
                        $e->add(11);
                        break;

                    case 2: // UPLOAD_ERR_FORM_SIZE
                        $e->add(12);
                        break;

                    case 3: // UPLOAD_ERR_PARTIAL
                        $e->add(13);
                        break;

                }


            // si le format de l'image est le bon
            } elseif(  $_FILES['csv_file']['type'] == "text/csv"
                    || preg_match( "#csv#i", $_FILES['csv_file']['name'] ) ) {

                // tous les pays
                $countries = Array();

                // on ouvre le fichier
                if( ($handle = fopen($_FILES['csv_file']['tmp_name'], "r")) !== FALSE ) {

                    // ligne par ligne
                    for($row = 1; ( $data = fgetcsv($handle, 1000, ";") ) !== FALSE; $row++ ) {

                        // nombre de colonne
                        $num = count($data);

                        // à partir de la 6ème ligne (on commence à 0)
                        if($row > 6) {
                            /*for ($c=0; $c < $num; $c++)
                                echo $data[$c] . "<br />\n";*/

                            // si le pays n'a pas déjà été contabilisé, on l'insère
                            if( !in_array($data[0], $countries) ) {

                                $countries[] = $data[0];
                                echo $data[0];

                                echo "<hr />";
                            }
                            
                        }
                        
                    }
                    
                    fclose($handle);
                    
                }

                
            } else $e->add(15);
            
            
        } else $e->add(16);
        

        exit("<br />".$e->doUrl() );
        
        return APP_URL."?".$e->doUrl()."#tabs-1";
    }
    
?>