<?php

    // Nous plaçons cette condition au début de chaque includes
    // elle garanti l'inclusion depuis les fichiers autorisés
    // (fichiers qui définissent la constante avec la bonne valeur)
    if(SAFE_PLACE != "FD622N18U8h7y4Xs76cO80QX5AfOWkvg") die();

    function doSwitchAction() {

        if( isset( $_REQUEST['action'] ) ) {
            
            $url = null;
            
            switch ($_REQUEST['action']) {

                    case "login":
                        $url = doLogin();
                        break;

                    case "logout":
                        $url = doLogout();
                        break;

                    case "generateDB":
                        $url = generateDB();
                        break;
                        
                    default:
                        $url = "index.php?err_log=16:0";
                        break;
            }

            if($url != null) {
                header("Location: ".$url);
                exit;
            }
        }
    }
    

    function _POST($name) {
        return nl2br( htmlspecialchars($_POST[$name], ENT_QUOTES, "UTF-8") );
    }


    
?>