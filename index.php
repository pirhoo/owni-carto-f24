<?php
    /** HP APP
    * @author Pierre Romera - pierre.romera@gmail.com
    * @version 1.0
    * @desc La page d'accueil de l'application
    */

    // Cette constante est une sécurité pour les includes
    define("SAFE_PLACE", "FD622N18U8h7y4Xs76cO80QX5AfOWkvg");
    define("ROOT_PATH", "./");
    // le coeur de l'application, c-a-d toute ce qu'il faut charger
    // ou définir avant de commencer à travailler...
    require_once(ROOT_PATH."includes/init.core.php");
    
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="fr" lang="fr">
    <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=990">


            <title><?php __(0); ?> - <?php __(1); ?></title>

            <!-- Pour utiliser le thème JQUERY UI -->
            <link type="text/css" rel="stylesheet" href="<?php echo THEME_DIR; ?>ui-lightness/jquery-ui-1.8.custom.css" />

            <!-- LE THÈME DE BASE -->
            <link type="text/css" rel="stylesheet" href="<?php echo THEME_DIR; ?>style.css" media="screen" />

            <!-- Pour utiliser JQUERY et JQUERY UI-->
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-1.4.2.min.js"></script>
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-ui-1.8.5.custom.min.js"></script>
            
            <!-- Pour générer des infobulles personnalisées -->
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-roro-hidden-title.js"></script>
            <!-- Des fonctions utiles homemade -->
            <script type="text/javascript" src="<?php echo JS_DIR; ?>roro-utils.js"></script>
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-roro-center.js"></script>

            <script type="text/javascript">
                $(document).ready(function () {
                    // centre les éléments avec la classe .center millieu de l'écran (ici l'app)
                    $(".center").center();

                    // Déclenche les infobulles personnalisées sur les éléments .share et leur ajoute la classe "shareTitle"
                    // Seulement si le visiteur n'est pas sur Ipad'
                    if(! RR_UTILS.isIpad()) {
                        $(".share").addTitle("shareTitle");
                        $(".copier").addTitle("copierTitle");
                    }

                    // cache le mask si on lui clique dessus
                    // sauf si il contient la classe "hold"
                    $("#mask").click(function () {
                        
                        // une classe hold permet de bloquer la fermeture du mask
                        if( ! $(this).hasClass("hold") ) {

                            // pas de fondu sur IPAD et IPHONE
                            if(RR_UTILS.isApple())
                                $(this).hide(0);
                            else
                                $(this).stop().fadeOut(300);
                        }
                    });
                    
                });
            </script>
    </head>
    <body onload="window.scrollTo(0, 1)">

        <?php
            // Hoot essentiel au bon fonctionement de l'API Facebook
            // (ici, plusieurs outils sont réuni dans une classe FBconnect)
            /* @var $FB FBconnect */
            $FB->doFBhoot();

            // Hoot essentiel au bon fonctionement de l'API Twitter
            /* @var $TW TWconnect */
            $TW->doTWhoot();
        ?>

        <!-- L'APP en elle même, de 990x667 -->
        <div id="app" class="center">

            <!-- Une surcouche sur la div APP avec un overflow hidden de 990x667 -->
            <div id="overflow">

                <!-- Là où l'application se déroule -->
                <div id="workspace"></div>

                <!-- Un masque sombre qui recouvre l'application (pour des popups) -->
                <div id="mask"></div>

            </div>
        </div>
    </body>
</html>