<?php


namespace GotTemplateExtension\OEObjects;

use GotTemplateExtension\OEObjects\OEObject;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;

class OESContainer extends OEObject
{
    private $_tExtends        = OSContainer::class;
    private $_tExtendIntances = "";

    public function __construct($id, $oeopath, $oopath)
    {
        parent::__construct($id, $oeopath, $oopath);

        $properties = $this->getProperties();

        $oeproperties = include __DIR__ . '/../../view/zf3-graphic-object-templating/oeobjects/oescontainer/oescontainer.config.php';
        foreach ($oeproperties as $oekey => $oeproperty) {
            $properties[$oekey] = $oeproperty;
        }
        /** @var OSContainer $objetCore */
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
        if (substr($funcName, 0, 3) !=  'get') {
            $savProperties  = $this->_tExtendIntances->getProperties();
        }
        if(method_exists($this->_tExtendIntances, $funcName))
        {
            $rc = call_user_func_array(array($this->_tExtendIntances, $funcName), $tArgs);
            if ($rc !== false) {
                if (substr($funcName, 0, 3) !=  'get') {
                    $properties     = $this->getProperties();
                    $curProperties  = $this->_tExtendIntances->getProperties();
                    foreach ($curProperties as $key => $curProperty) {
                        if ($curProperty != $savProperties[$key]) {
                            $properties[$key] = $curProperty;
                        }
                    }
                    $this->setProperties($properties);
                    $this->saveProperties();
                    return $this;
                } else {
                    return $rc;
                }
            }
        }
        throw new \Exception("The $funcName method doesn't exist");
    }

    public function __get($nameChild) {
        $properties = $this->getProperties();
        if (!empty($properties['children'])) {
            foreach ($properties['children'] as $idChild => $child) {
                $obj = OObject::buildObject($idChild);
                $name = $obj->getName();
                if ($name == $nameChild) return $obj;
            }
        }
        return false;
    }

    public function setTExtendInstances(OObject $object)
    {
        $this->_tExtendIntances = $object;
        return $this;
    }
}