<?php


    // Nous plaçons cette condition au début de chaque includes
    // elle garanti l'inclusion depuis les fichiers autorisés
    // (fichiers qui définissent la constante avec la bonne valeur)
    if(SAFE_PLACE != "FD622N18U8h7y4Xs76cO80QX5AfOWkvg") die();
    

    //    --
    //    -- Structure de la table `option`
    //    --
    //
    //    CREATE TABLE IF NOT EXISTS `option` (
    //      `ID` bigint(20) NOT NULL AUTO_INCREMENT,
    //      `option_name` varchar(255) NOT NULL,
    //      `option_value` varchar(255) NOT NULL,
    //      PRIMARY KEY (`ID`)
    //    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;


    function get_appinfo($option_name, $alternate = -1, $ID = false) {

       /* @var $database dbMySQL */
        global $database;

        // tableau static contenant la liste des options
        static $options = Array();

        if( count($options) == 0 ) {
            
            $res = $database->query( "SELECT * FROM ".TABLE_PREFIX."option" );
            if(!$res) die( $database->error[0] );
            
            // enregistre toutes les options
            while($row = $database->fetch() )
               $options[ $row["option_name"] ] = $row;
            
        }

        if($ID)
            return array_key_exists($option_name, $options) ? $options[$option_name]["ID"] : $alternate ;
        else
            return array_key_exists($option_name, $options) ? $options[$option_name]["option_value"] : $alternate ;

    }


    function appinfo($option_name, $alternate = -1, $ID = false ) {
        echo get_appinfo($option_name, $alternate, $ID);
    }

    function checkRequiredOptions() {
        // ici la liste des options obligatoire au bon fonctionement de l'APP
        return (
                (get_appinfo("option_nane") != -1)
                || 1
               ) or die("Veuillez d'abord configurer l'application");
    }

    function updateOption($name, $value = "", $safeMode = false) {
        
        /* @var $database dbMySQL */
        global $database;

        if($value == "" && !$safeMode) {

            $query = "DELETE FROM ".TABLE_PREFIX."option WHERE option_name='$name' ";
            $database->query($query);
            
        } else {
            // l'option n'existe pas
            if(get_appinfo($name) == -1) {

                    $query = "INSERT INTO ".TABLE_PREFIX."option VALUES('', '$name', '$value')";
                    $database->query($query);

            // elle existe, on la met à jour
            } else {

                    $query = "UPDATE ".TABLE_PREFIX."option SET option_value='$value' WHERE option_name='$name' ";
                    $database->query($query);

            }
        }
            
    }
    
?>
