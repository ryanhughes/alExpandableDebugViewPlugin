<?php
// Copyright 2010, 2012 Alaress Pty Ltd. http://alaress.com.au

/**
 * Traversable object formatter
 *
 * @author Ryan Hughes <ryan.hughes@alaress.com.au>
 */
class alExpandableDebugPanelView extends sfWebDebugPanelView {

    protected function formatObjectAsHtml($name, $parameter) {

        if ($parameter instanceof Doctrine_Collection) {
            return $this->formatDoctrineCollectionAsHtml($name, $parameter);
        }
        elseif ($parameter instanceof Doctrine_Record) {
            return $this->formatArrayAsHtml($name, $parameter);
        }
        else {
            return parent::formatObjectAsHtml($name, $parameter);
        }
    }

    public function formatDoctrineCollectionAsHtml($name, Doctrine_Collection $collection) {

        static $i = 0;

        $i++;

        $html = array();
        $html[] = $this->getParameterDescription($name, $collection);
        $html[] = $this->getToggler('sfWebDebugViewDoctrineCollection' . $i);
        $html[] = '<div id="sfWebDebugViewDoctrineCollection' . $i . '" style="display:none">';
        $html[] = '<ul>' . $this->formatItemsAsHtml($collection, $name . "[%s]") . '</ul>';


        $html[] = '</div>';

        return join("\n", $html);
    }

    public function formatArrayAsHtml($name, $parameter, $nameFormat = '%s') {

        static $i = 0;

        $i++;

        $html = array();

        $html[] = $this->getParameterDescription(sprintf($nameFormat, $name), $parameter);
        $html[] = $this->getToggler('sfWebDebugViewArray' . $i);
        $html[] = '<div id="sfWebDebugViewArray' . $i . '" style="display:none">';
        $html[] = '<ul>' . $this->formatItemsAsHtml($parameter, $name . '[%s]') . '</ul>';


        $html[] = '</div>';

        return join("\n", $html);
    }

    public function formatItemsAsHtml($parameter, $nameFormat = '%s') {

        $html = array();

        foreach ($parameter as $fieldName => $fieldValue) {

            $name = sprintf($nameFormat, $this->varExport($fieldName));

            if (is_array($fieldValue) || $fieldValue instanceof Doctrine_Record) {
                $html[] = $this->formatItemsAsHtml($fieldValue, $name . "[%s]");
            } elseif ($fieldValue instanceof Doctrine_Collection) {
                $html[] = '<ul>' . $this->formatDoctrineCollectionAsHtml($name, $fieldValue) . '<ul>';
            } else {
                $html[] = '<li>';
                $html[] = $this->getParameterDescription($name, $fieldValue);
                $html[] = '</li>';

            }
        }

        return join("\n", $html);
    }

}
