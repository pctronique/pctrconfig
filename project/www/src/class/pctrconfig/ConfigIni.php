<?php
// verifier qu'on n'a pas deja creer la classe
if (!class_exists('ConfigIni')) {

    /* en cas d'erreur sur la classe */
    include_once __DIR__ . '/../pctrouting/Path.php';

    /* recuperer l'emplacement du fichier de configuration */
    if (!defined('RACINE_CONFIG_INI') && file_exists(__DIR__ . '/../../config/config.php')) {
        include_once __DIR__ . '/../../config/config.php';
    } else if (!defined('RACINE_CONFIG_INI') && !file_exists(__DIR__ . '/../../config/config.php')) {
        define("RACINE_CONFIG_INI", __DIR__."/../../config/");
    }

    /**
     * Creation de la class pour la lecture du fichier ini avec les configurations
     * (Numéro d'error de la classe '1001XXXXXX')
     * @version 1.1.0
     * @author pctronique (NAULOT ludovic)
     */
    class ConfigIni {

        /**
         * Le contenu du fichier ini
         *
         * @var array du contenu du fichier ini
         */
        protected array|null $arrayIni;



        /**
         * le constructeur par reference
         * 
         * @param string|null $file_config le fichier de configuration
         * @throws \Exception
         * @throws \Error
         */
        public function __construct(string|null $file_config = null) {
            if(empty($file_config)) {
                // recuperer le fichier de configuration
                $path = new Path(RACINE_CONFIG_INI, "config.ini");
                $file_config = $path->getAbsolutePath();
            } else {
                $path = new Path(__DIR__, $file_config);
                $file_config = $path->getAbsolutePath();
            }
            if(!file_exists($file_config)) {
                $file_config .= ".example";
            }
            // en cas d'erreur
            if(!file_exists($file_config)) {
                try {
                    throw new Exception("Le fichier de configuration n'a pas ete trouve.\n");
                } catch (Exception $e) {
                    throw new Error($e, 1001000000);
                }
            } else {
                try {
                    $this->arrayIni = parse_ini_file($file_config, true);
                } catch (Exception $e) {
                    throw new Error($e, 1001000001);
                }
            }

        }

        /**
         * Recuperer une valeur a partir d'une clef et d'une section.
         * 
         * @param string|null $key la clef
         * @param string|null $section la section
         * @return string|null la valeur
         */
        protected function value(string|null $key, string|null $section):string|null {
            if(!empty($this->arrayIni) && !(empty($key) && empty($section))) {
                if(!empty($section)) {
                    if (array_key_exists($section, $this->arrayIni)) {
                        if (array_key_exists($key, $this->arrayIni[$section])) {
                            return $this->arrayIni[$section][$key];
                        }
                    }
                } else  {
                    if (array_key_exists($key, $this->arrayIni)) {
                        return $this->arrayIni[$key];
                    }
                }
            }
            return "";
        }

        /**
         * Recuperer le chemin du dossier parent.
         * 
         * @return string|null le chemin du dossier parent
         */
        public function pathParent():string|null {
            return RACINE_CONFIG_INI;
        }

    }
    

}
