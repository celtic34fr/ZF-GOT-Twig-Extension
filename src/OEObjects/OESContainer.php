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

        $oeproperties = include __DIR__ . '/../../../view/zf3-graphic-object-templating/oeobjects/oescontainer/oescontainer.config.php';
        foreach ($oeproperties as $oekey => $oeproperty) {
            $properties[$oekey] = $oeproperty;
        }
        /** @var OSContainer $objetCore */
        $objetCore = new $this->_tExtends('');
        $corProperties = $objetCore->getProperties();
        foreach ($corProperties as $corKey => $corProperty) {
            if (!array_key_exists($corKey, $properties)) {
                $properties[$corKey] = $corProperties;
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
        { return call_user_func_array(array($this->_tExtendIntances, $funcName), $tArgs); }
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