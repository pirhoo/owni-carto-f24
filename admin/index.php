<?php
    /** HP APP
    * @author Pierre Romera - pierre.romera@gmail.com
    * @version 1.0
    * @desc La page d'accueil de l'application
    */

    // Cette constante est une sécurité pour les includes
    define("SAFE_PLACE", "FD622N18U8h7y4Xs76cO80QX5AfOWkvg");
    define("ROOT_PATH", "../");
    
    // le coeur de l'application, c-a-d toute ce qu'il faut charger
    // ou définir avant de commencer à travailler...
    require_once(ROOT_PATH."includes/init.core.php");

    if(!isAllowed())
        header("location: ".APP_URL."auth.php");
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="fr" lang="fr">
    <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=990">


            <title><?php __(0); ?> &lsaquo; <?php __(1); ?></title>

            <!-- Pour utiliser le thème JQUERY UI -->
            <link type="text/css" rel="stylesheet" href="<?php echo THEME_DIR; ?>smoothness/jquery-ui-1.8.5.custom.css" />

            <!-- LE THÈME DE BASE -->
            <link type="text/css" rel="stylesheet" href="<?php echo THEME_DIR; ?>admin.css" media="screen" />

            <!-- Pour utiliser JQUERY et JQUERY UI-->
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-1.4.2.min.js"></script>
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-ui-1.8.5.custom.min.js"></script>
            
            <!-- Pour générer des infobulles personnalisées -->
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-roro-hidden-title.js"></script>
            <!-- Des fonctions utiles homemade -->
            <script type="text/javascript" src="<?php echo JS_DIR; ?>roro-utils.js"></script>
            <script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-roro-center.js"></script>
            
            <script type="text/javascript">
                $(function() {
                    $("#app").tabs();
                    $(".datepicker").datepicker();
                    $("input:submit,input[type=button]").button();

                    $(".delete_article").click(function () {
                        return confirm("Êtes-vous certain de vouloir supprimer cet article ?");
                    });
                });
            </script>

    </head>
    <body onload="window.scrollTo(0, 1)">
        
        <?php
            if($e->hasErr()) { ?>
            <div class="msg-log">
                <div class="ui-corner-bottom bulle">
                    <ul>
                        <?php
                            foreach( $e->getLog() as $err)
                                if($err["type"] == 1)
                                    echo "<li><span class='ui-icon ui-icon-info'></span>".__($err["ID"], 0)."</li>";
                                elseif($err["type"] == 0)
                                    echo "<li class='ui-state-error-text'><span class='ui-icon ui-icon-alert'></span>".__($err["ID"], 0)."</li>";
                        ?>
                    </ul>
                    <div style="text-align:right; font-size:0.8em; margin-bottom:5px;">
                        <input type="button" class="close-errors-log" value="Fermer" />
                    </div>
                </div>
            </div>
            <script type="text/javascript">

                $(".msg-log").css({opacity:0,marginTop:-1 * $(".msg-log .bulle").outerHeight() });


                $(function () {
                    $(".msg-log").animate({opacity:1,display:'block',marginTop:0 },700);
                });


                $(".close-errors-log").click(function () {
                    $(".msg-log").animate({opacity:0,display:'none',marginTop:-1 * $(".msg-log .bulle").outerHeight() },700);
                });
                
            </script>
        <?php } ?>
        
        <h1><?php __(0); ?> &lsaquo; <?php __(1); ?></h1>
        <div id="app" class=".tabs">
                <div class="ui-state-default ui-corner-all back-app"><span  class="ui-icon ui-icon-arrowreturnthick-1-n"></span><a  href="../index.php">Voir l'application</a></div>



                <!-- --------------------------------------------------------------------------------------
                ---  ONGLETS PRINCIPAUX
                ---- -------------------------------------------------------------------------------------->

                <ul>
                    <li><a href="#tabs-1">Paramétrer l'application</a></li>
                </ul>



                <!-- --------------------------------------------------------------------------------------
                ---  PARAMÈTRES DE L'APPLICATION
                ---- -------------------------------------------------------------------------------------->

                <div id="tabs-1">
                    <h2>Générer la base de données</h2>
                    <form action="index.php?action=generateDB" method="POST" enctype="multipart/form-data">

                        <em>Attention, cette opération est lourde. Il s'agit en effet de générer (ou regénérer) une base de données dans sa totalité. Cet acte n'est pas annodin, soyez raisonnables...</em>
                        <div class="labelling odd">
                            <label for="csv_file">Choisissez le CSV à utiliser : </label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="3072000">
                            <input type="file" name="csv_file" id="csv_file"  />
                        </div>


                        <div style="text-align:right">
                            <input type="submit" value="Générer" />
                        </div>
                    </form>
                </div>
        </div>

        <div class="footer">
            Une application propulsée par <a href="http://22mars.com">22mars</a> | <a href="index.php?action=logout">Déconnexion</a>
        </div>

    </body>
</html>
<?php echo exit; ?>