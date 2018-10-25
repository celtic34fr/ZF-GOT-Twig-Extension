<?php

namespace GotTemplateExtension\OEObjects;

use GotTemplateExtension\OEObjects\OEObject;
use GraphicObjectTemplating\OObjects\ODContained;

class OEDContained extends OEObject
{
    private $_tExtends        = ODContained::class;
    private $_tExtendIntances = "";

    public function __construct($id, $oeopath, $oopath)
    {
        parent::__construct($id, $oeopath, $oopath);

        $properties = $this->getProperties();

        $oeproperties = include __DIR__ . '/../../../view/zf3-graphic-object-templating/oeobjects/oedcontained/oedcontained.config.php';
        foreach ($oeproperties as $oekey => $oeproperty) {
            $properties[$oekey] = $oeproperty;
        }
        /** @var ODContained $objetCore */
        $objetCore = new $this->_tExtends($id, $oopath);
        $corProperties = $objetCore->getProperties();
        foreach ($corProperties as $corKey => $corProperty) {
            if (!array_key_exists($corKey, $properties)) {
                $properties[$corKey] = $corProperty;
            }
        }
        $objetCore->setId($id);
        $this->_tExtendIntances = $objetCore;

        $this->setProperties($properties);
        $this->saveProperties();
        return $this;
    }


    public function __call($funcName, $tArgs)
    {
        if(method_exists($this->_tExtendIntances, $funcName))
        {
            $rc = call_user_func_array(array($this->_tExtendIntances, $funcName), $tArgs);
            if ($rc !== false) {
                if (substr($funcName, 0, 3) !=  'get') {
                    $this->setProperties($this->_tExtendIntances->getProperties());
                    $this->saveProperties();
                }
                return $this;
            }
        }
        throw new \Exception("The $funcName method doesn't exist");
    }

    public function setTExtendInstances(ODContained $object)
    {
        $this->_tExtendIntances = $object;
        return $this;
    }
}