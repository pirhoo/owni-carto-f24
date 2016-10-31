<?php

    /** init.core.php
    * @author Pierre Romera - pierre.romera@gmail.com
    * @version 1.0
    * @desc Charge les composants essentiels de l'application
    */
    
    // Nous plaçons cette condition au début de chaque includes
    // elle garanti l'inclusion depuis les fichiers autorisés
    // (fichiers qui définissent la constante avec la bonne valeur)
    if(SAFE_PLACE != "FD622N18U8h7y4Xs76cO80QX5AfOWkvg") die();    


    // permet d'afficher les messages d'erreur
    if(!isset($_GET['debug'])) {
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        error_reporting(E_ALL);
    }


    // Cette constante est essentielle au bon fonctionement de l'app,
    // elle indique le dossier rassemblant toutes les librairies php, js et le thème css
    // (tout ce qui est inclue d'une façon ou d'une autre)
    define("INC_DIR", ROOT_PATH."includes/");
    
    // le repertoire contenant les images
    define("CONTENT_DIR", ROOT_PATH."content/");

    require_once (INC_DIR."func.action.php");
    // Fonctions permettant de créer une application multi-langues
    require_once (INC_DIR."func.lang.php");
    // Fonctions permettant d'utiliser les options de l'APP
    require_once (INC_DIR."func.option.php");
    // Fonctions permettant d'authentifier l'utilisateur
    require_once (INC_DIR."func.auth.php");
    // Classe permettant d'établir une connexion avec MySql
    require_once (INC_DIR."class.Mysql.php");
    // Classe permettant de ce connecter à l'aide de Facebook Connect
    require_once (INC_DIR."class.FBconnect.php");
    // Classe pour twitter connect
    require_once (INC_DIR."class.TWconnect.php");
    // Classe permettent de loguer les erreurs
    require_once (INC_DIR."class.ErrorsLog.php");
    
    //  --- --- ---

    // Les fonctions propres à l'APP
    require_once (INC_DIR."func.app.php");



    // Ecran courrant de l'application
    // (typiquement, il serra contenut dans la div #workspace)
    if(!isset($_GET['e']))
        define("ECRAN", 1);
    else
        define("ECRAN", $_GET['e']);


    // D'autres implacements indispensables,
    // sous répertoires de INC_DIR:

    // le répertoire qui contient les fichiers de langue
    define("LANG_DIR", INC_DIR."lang/");
    // le répertoire qui contient le style
    define("THEME_DIR", INC_DIR."style/");
    // le répertoire qui contient les javascript
    define("JS_DIR", INC_DIR."js/");

    // url de l'APP
    define("APP_URL", "http://".$_SERVER["SERVER_NAME"].str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]) );


    /* @var $e ErrorsLog */
    $e = new ErrorsLog();
    global $e;


    // MySQL
    // inspensable pour faire cohabiter plusieurs de ces apps
    define('TABLE_PREFIX', 'carto_');

    /* @var $database dbMySQL */
    $database = new dbMySQL("carto-F24", "root", "rootmdp", "localhost");
    global $database;

    // Etablis la connexion à la BDD
    $database->connection();

    if(!isset($_SESSION)) session_start();
    //session_destroy();

    // Configuration pour Twitter
    // --------------------------
    define("TW_CONSUMER_KEY",    "9sa8zeQaLZFvAqptcaJi2w");
    define("TW_CONSUMER_SECRET", "UD8QQbMjgCHcVEahTOUCIUBbsge7owg8TfLHsaf9qA");
    define("TW_OAUTH_CALLBACK",  APP_URL);

    // pour s'authentifier auprès de Twitter
    $TW = new TWconnect(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, TW_OAUTH_CALLBACK);
    global $TW;

    // Configuration Facebook Connect
    // ------------------------------

    // L'ID de l'APP Facebook
    // (conf http://www.facebook.com/developers/ )
    define('FACEBOOK_APP_ID', '100469823352520');
    // Passphrase de l'APP Facebook
    define('FACEBOOK_SECRET', '3414fc723d49cce6caca11cef549247f');


    /* @var $FB FBconnect */
    $FB = new FBconnect(FACEBOOK_APP_ID, FACEBOOK_SECRET);
    global $FB;

    // EXEMPLE ---------------
    // Force une pseudo connexion à l'aide d'un token personalisé...
    // Pour trouver un token http://developers.facebook.com/docs/api
    //
    //$FB->startSimulation("2227470867|2._c1CE42SzMJlVlsMzse8ww__.3600.1286384400-686299757|xyS_MAaK3_MDW1W8OGgfQRFICjA");
    // --------------------------------------------------------------------------------------------------------------------


    // On défini la langue de l'application:
    // Si une langue est demandée (en GET), on la défini
    // (seulement un jeu de langue est autorisé dans cette fonction)
    if(!isset($_GET['lang']))
        defineLang();
    else
        defineLang($_GET['lang']);

    
    doSwitchAction();

?>
