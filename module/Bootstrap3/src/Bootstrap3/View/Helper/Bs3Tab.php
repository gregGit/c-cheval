<?php

namespace Bootstrap3\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Bs3Tab extends AbstractHelper
{

    /**
     * Classe CSS de la ul.tablist sous forme de chaine
     * @var type 
     */
    private $_tablistClass = '';
    private $_tabContentClass;

    /**
     * Préfix pour les identifiants des tabs
     * @var type 
     */
    private $_tabIdPrefix = 'bs3_tab';

    /**
     * aTabs
     * Tableau contenant les tabs.
     * @var array
     */
    protected $aTabs;

    
    private $_activeTab;
    public function __invoke(array $tabs = null,$activeTab=0, $options = null)
    {
        $this->aTabs = array();
        $this->_activeTab=$activeTab;
        $this->setOptions($options);
        if ($tabs === null) {
            return new self;
        }
        $this->addPanels($tabs);
        return $this->render();
    }
    
    public function setActiveTab($index) {
        $this->_activeTab=$index;
    }

    protected function getOption($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } elseif (isset($this->{"_$name"})) {
            return $this->{"_$name"};
        } else {
            return '';
        }
    }

    public function render()
    {
        $html = '';
        $html.=$this->openTagTabs();
        $html.=$this->renderTabList();
        $html.=$this->renderTabContent();
        $html.=$this->closeTagTabs();
        return $html;
    }

    public function renderTabContent()
    {
        $html = '';
        $html.=$this->openTagTabContent();
        foreach ($this->aTabs as $paneIndex => $pane) {
            $html.=$this->renderTabPane($paneIndex);
        }
        $html.=$this->closeTagTabContent();
        return $html;
    }

    public function openTagTabContent()
    {
        return sprintf('  <div class="tab-content %s">', $this->getOption('tabContentClass'));
    }

    public function closeTagTabContent()
    {
        return '</div>';
    }

    public function renderTabPane($paneIndex)
    {
        $html = '';
        $id = isset($this->aTabs[$paneIndex]['options']['tabId']) ? $this->aTabs[$paneIndex]['options']['tabId'] : $this->_tabIdPrefix . '_' . $paneIndex;
        $class = isset($this->aTabs[$paneIndex]['options']['tabPanelClass']) ? $this->aTabs[$paneIndex]['options']['tabTitleClass'] : '';
        if($paneIndex==$this->_activeTab) {
            $class.=' active';
        }        
        $html.=sprintf('<div role="tabpanel" class="tab-pane %s" id="%s">', $class, $id);
        $html.=$this->aTabs[$paneIndex]['content'];
        $html.='</div>';
        return $html;
    }

    public function renderTabList()
    {
        $html = '';
        $html.=$this->openTagTabList();
        foreach ($this->aTabs as $paneIndex => $pane) {
            $html.=$this->renderTab($paneIndex);
        }
        $html.=$this->closeTagTabList();
        return $html;
    }

    public function renderTab($paneIndex)
    {
        $html = '';
        $id = isset($this->aTabs[$paneIndex]['options']['tabId']) ? $this->aTabs[$paneIndex]['options']['tabId'] : $this->_tabIdPrefix . '_' . $paneIndex;
        $class = isset($this->aTabs[$paneIndex]['options']['tabTitleClass']) ? $this->aTabs[$paneIndex]['options']['tabTitleClass'] : '';
        if($paneIndex==$this->_activeTab) {
            $class.=' active';
        }
        $html.=sprintf('<li role="presentation" class="%s">', $class);
        $html.=sprintf('<a href="#%1$s" aria-controls="%1$s" role="tab" data-toggle="tab">%2$s</a>', $id, $this->aTabs[$paneIndex]['title']);
        $html.='</li>';
        return $html;
    }

    public function openTagTabList()
    {
        return sprintf('<ul class="nav nav-tabs %s" role="tablist">', $this->getOption('tabPanelClass'));
    }

    public function closeTagTabList()
    {
        return '</ul>';
    }

    public function openTagTabs()
    {
        return '<div>';
    }

    public function closeTagTabs()
    {
        return '</div>';
    }

    public function setOptions(array $options = null)
    {
        return $this;
    }

    /**
     * $aPanels : tableau associatif(title, content, options), ou tableau indexé (title, content, options)
     * @param array $aPanels
     */
    public function addPanels(array $aPanels)
    {
        foreach ($aPanels as $key => $panel) {
            if (!is_array($panel)) {
                continue;
            }
            if (array_key_exists('title', $panel)) {
                $title = $panel['title'];
                $content = isset($panel['content']) ? $panel['content'] : '';
                $options = isset($panel['options']) ? $panel['options'] : null;
            } else {
                $title = $panel[0];
                $content = isset($panel[1]) ? $panel[1] : '';
                $options = isset($panel[2]) ? $panel[2] : null;
            }
            $this->addTabPanel($title, $content, $options);
        }
        return $this;
    }

    /**
     * Ajout d'un panel
     * 
     * Options :
     * _ tabId : Identifiant de la tab (sinon on se sert de tabIdentifier)
     * _ tabTitleClass : Class CSS du LI
     * _ tabPanelClass: Class CSS du div.tab-pane
     * @param type $title Titre
     * @param type $content Contenu HTML
     * @param type $tabid Identifiant de la tab tabXXX sinon
     * @param type $tabOption Tableau d'options
     */
    public function addTabPanel($title, $content = '', $tabOption = null)
    {
        $pane = array(
            'title' => $title,
            'content' => $content,
            'tabId' => isSet($tabOption['tabId']) ? $tabOption['tabId'] : '',
            'tabTitleClass' => isSet($tabOption['tabTitleClass']) ? $tabOption['tabTitleClass'] : '',
            'tabPanelClass' => isSet($tabOption['tabPanelClass']) ? $tabOption['tabPanelClass'] : '',
        );

        $this->aTabs[] = $pane;
        return $this;
    }

}
