<?php

namespace GotTemplateExtension\OEObjects;

use Exception;
use GraphicObjectTemplating\OObjects\OObject;

class OEObject extends OObject
{
    /**
     * OEObject constructor.
     * @param string $id identifiant de l'objet
     * @param array $oeopath chemin total du fichier de configuration de l'objet étendu
     * @param array $oopath chemin partiel de l'objet core de référence
     * @throws Exception
     */
    public function __construct(string $id, array $oeopath, array $oopath)
    {
        parent::__construct($id, $oopath);
        $properties = $this->getProperties();

        if (!empty($oeopath)) {
            $oeopath[] = __DIR__ . '/../../view/zf3-graphic-object-templating/oeobjects/oeobject.config.php';
            while ($oepath = array_pop($oeopath)) {
                if (is_file($oepath)) {
                    $objProperties = include $oepath;
                    foreach ($objProperties as $objKey => $objProperty) {
                        $properties[$objKey] = $objProperty;
                    }

                    /** gestyion des resources de l'objet étendu */
                    $pathRscs   = substr($oepath, 0, strlen($oepath) - 10).'rscs.php';
                    if (is_file($pathRscs)) {
                        $rscsObj = include $pathRscs;
                        if ($rscsObj) {
                            $sessionObj     = OObject::validateSession();
                            $rscsSession    = $sessionObj->resources ?? [];
                            $prefix         = 'gotextension/' . $rscsObj['prefix'] . 'oeobjects/';
                            unset($rscsObj['prefix']);
                            foreach ($rscsObj as $type => $filesInfo) {
                                if (!array_key_exists($type, $rscsSession)) {
                                    $rscsSession[$type] = [];
                                }
                                foreach ($filesInfo as $name => $path) {
                                    $rscsSession[$type][$name] = $prefix . $properties['typeObj'] . '/' . $properties['object'] . '/' . $path;
                                }
                            }
                            $sessionObj->resources = $rscsSession;
                        }
                    }
                }
            }

            $templateName = 'zf3-graphic-object-templating/oeobjects/' . $objProperties['typeObj'];
            $templateName .= '/' . $objProperties['object'] . '/' . $objProperties['template'];
            $properties['template'] = $templateName;
            $this->setProperties($properties);
            $this->saveProperties();
            return $this;
        }

        return false;
    }
}