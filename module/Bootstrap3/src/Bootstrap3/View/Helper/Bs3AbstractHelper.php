<?php

namespace Bootstrap3\View\Helper;

use Zend\View\Helper\AbstractHelper;

Abstract class Bs3AbstractHelper extends AbstractHelper
{

    protected $helperAttribs = array();
    protected $helperTag = 'div';

    protected function setHelperTag($value)
    {
        $this->helperTag = $value;
        return $this;
    }

    public function setOptions(array $options = null)
    {
        if (null === $options) {
            return $this;
        }
        foreach ($options as $name => $value) {
            if ($name == 'attribs') {
                $this->addHelperAttribs($value);
            }
            $this->setOption($name, $value);
        }
        return $this;
    }

    public function setOption($name, $value)
    {
        if (property_exists(get_class($this), $name)) {
            $this->$name = $value;
            return $this;
        }
        if (property_exists(get_class($this), '_' . $name)) {
            $this->{"_$name"} = $value;
            return $this;
        }
        return $this;
    }

    public function addClass($class)
    {
        return $this->addHelperAttrib('class', $class);
    }

    protected function addHelperAttribs(array $attribs)
    {
        foreach ($attribs as $name => $value) {
            $this->addHelperAttrib($name, $value);
        }
        return $this;
    }

    protected function setHelperAttrib($name, $value)
    {
        $this->helperAttribs[$name] = '';
        return $this->addHelperAttrib($name, $value);
    }

    protected function addHelperAttrib($name, $value)
    {
        if (!isset($this->helperAttribs[$name])) {
            $this->helperAttribs[$name] = '';
        }
        $this->helperAttribs[$name] = $this->getAttribValue(array($this->helperAttribs[$name], $value));
        return $this;
    }

    public function openHelperTag()
    {
        $html = '';
        $html.='<' . $this->helperTag;
        foreach ($this->helperAttribs as $name => $value) {
            $html.=sprintf(' %s="%s"', $name, $this->getAttribValue($value));
        }
        $html.='>';
        return $html;
    }

    public function closeHelperTag()
    {
        $html = '';
        $html.='</' . $this->helperTag;
        $html.='>';
        return $html;
    }

    protected function getAttribValue($value)
    {
        $aRet = array();
        if (is_array($value)) {
            foreach ($value as $val) {
                if (empty($val)) {
                    continue;
                }
                $aRet[] = htmlentities(trim($val), ENT_QUOTES);
            }
        } else {
            $aRet[] = htmlentities(trim($value), ENT_QUOTES);
        }

        return implode(' ', $aRet);
    }

    protected static function is_assoc($arr)
    {
        if (!is_array($arr)) {
            return false;
        }
        if (empty($arr)) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

}
