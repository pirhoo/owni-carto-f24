<?php

    // Nous plaçons cette condition au début de chaque includes
    // elle garanti l'inclusion depuis les fichiers autorisés
    // (fichiers qui définissent la constante avec la bonne valeur)
    if(SAFE_PLACE != "FD622N18U8h7y4Xs76cO80QX5AfOWkvg") die();

    //    --
    //    -- Structure de la table `user`
    //    --
    //
    //    CREATE TABLE IF NOT EXISTS `user` (
    //      `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
    //      `user_pseudo` varchar(255) NOT NULL,
    //      `user_password` varchar(255) NOT NULL,
    //      PRIMARY KEY (`ID`)
    //    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

    function isAllowed() {
        /* @var $database dbMySQL */
        global $database;

        if( isset($_SESSION["pseudo"])
        &&  isset($_SESSION["password"]) ) {

            $query = "SELECT ID FROM ".TABLE_PREFIX."user WHERE user_pseudo='".$_SESSION["pseudo"]."' AND user_password='".$_SESSION["password"]."'";
            $database->query($query);

            return $database->numrows() == 1;
            
        } else return false;
        
    }

    function doLogin() {
        /* @var $e ErrorsLog */
        global $e;

        if( isset($_POST["pseudo"])
        &&  isset($_POST["password"]) ) {

            $_SESSION["pseudo"]   = $_POST["pseudo"];
            $_SESSION["password"] = md5($_POST["password"]);

        }

        if(isAllowed()) {
            $e->add(20,1);
            return APP_URL."?".$e->doUrl()."#tabs-1";
            
        } else {
            
            $e->add(21,0);
            return APP_URL."auth.php?".$e->doUrl()."#tabs-1";
        }
                
    }
    
    function doLogout() {
        /* @var $e ErrorsLog */
        global $e;

        $_SESSION["pseudo"]   = $_POST["pseudo"];
        $_SESSION["password"] = md5($_POST["password"]);

        $e->add(23,1);
        return APP_URL."auth.php?".$e->doUrl()."#tabs-1";

    }
?>
