<?php

namespace GotTemplateExtension\OEObjects;

use GraphicObjectTemplating\OObjects\OObject;

class OEObject extends OObject
{
    /**
     * OEObject constructor.
     * @param $id       identifiant de l'objet
     * @param $oeopath  chemin total du fichier de configuration de l'objet étendu
     * @param $oopath   chemin partiel de l'objet core de référence
     * @throws \Exception
     */
    public function __construct($id, $oeopath, $oopath)
    {
        parent::__construct($id, $oopath);
        $properties = $this->getProperties();

        $oeproperties = include __DIR__ . '/../../view/zf3-graphic-object-templating/oeobjects/oeobject.config.php';
        foreach ($oeproperties as $oekey => $oeproperty) {
            $properties[$oekey] = $oeproperty;
        }

        if (!empty($oeopath)) {
            if (is_file($oeopath)) {
                $objProperties = include $oeopath;
                foreach ($objProperties as $objKey => $objProperty) {
                    $properties[$objKey] = $objProperty;
                }

                $templateName = 'zf3-graphic-object-templating/oeobjects/' . $objProperties['typeObj'];
                $templateName .= '/' . $objProperties['object'] . '/' . $objProperties['template'];
                $properties['template'] = $templateName;
                $this->setProperties($properties);
                $this->saveProperties();
                return $this;
            }
        }
        return false;
    }
}