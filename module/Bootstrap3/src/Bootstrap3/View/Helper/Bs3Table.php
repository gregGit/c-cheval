<?php

namespace Bootstrap3\View\Helper;

use Bootstrap3\View\Helper\Bs3AbstractHelper;

class Bs3Table extends Bs3AbstractHelper
{

    const _STRIPPED = "table-stripped";
    const _BORDERED = "table-bordered";
    const _HOVER = "table-hover";
    const _CONDENSED = "table-condensed";

    private $_tbodyRows;

    public function __invoke(array $datas = null, $classes = null)
    {
        $this->setHelperTag('table')
                ->addHelperAttrib('class', 'table');

        $this->addClass($classes);
        if ($datas === null) {
            return new self;
        }
        return $this->render();
    }

    public function addTbodyRow(array $row)
    {
        $this->_tbodyRows[] = $row;
        return $this;
    }

    public function renderTBody()
    {
        $html = '';
        $html.='<tbody>';
        foreach ($this->_tbodyRows as $row) {
            
        }
        $html.='</tbody>';
    }

    public function renderRow($row)
    {
        $html = '';
        if (array_key_exists('colvalues', $row) && array_key_exists('colspans', $row)) {
            foreach ($row['colvalues'] as $i => $value) {
                $html.=$this->renderCell($value, $row['colspans'][$i]);
            }
        } else {
            foreach ($row as $i => $value) {
                $html.=$this->renderCell($value);
            }
        }
        return $html;
    }

    public function renderCell($value, $span = null)
    {
        $html = '';
        if (empty($span)) {
            $html.='<td>';
        } else {
            $html.=sprintf('<td colspan="%d">', $span);
        }
        $html.=$value;
        $html.='</td>';
        return $html;
    }

   
    public function setBordered()
    {
        $this->addClass(self::_BORDERED);
        return $this;
    }

    public function setStripped()
    {
        $this->addClass(self::_STRIPPED);
        return $this;
    }

    public function setHover()
    {
        $this->addClass(self::_HOVER);
        return $this;
    }

    public function setCondensed()
    {
        $this->addClass(self::_CONDENSED);
        return $this;
    }

    public function addClass($class)
    {
        return $this->addHelperAttrib('class', $class);
    }

    public function render()
    {
        $html = '';
        $html.=$this->openHelperTag();
        $html.=$this->closeHelperTag();
        return $html;
    }

}
