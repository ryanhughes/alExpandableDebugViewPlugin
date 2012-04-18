<?php
// Copyright 2010, 2012 Alaress Pty Ltd. http://alaress.com.au

/**
 * alExpandableDebugViewPlugin Configuration
 *
 * @author Ryan Hughes <ryan.hughes@alaress.com.au>
 */
class alExpandableDebugViewPluginConfiguration extends sfPluginConfiguration {

    public function initialize() {
        $this->dispatcher->connect('debug.web.load_panels', array($this, 'configureWebDebugToolbar'));
    }

    public function configureWebDebugToolbar(sfEvent $event) {

        $webDebugToolbar = $event->getSubject();

        $webDebugToolbar->setPanel('view', new alExpandableDebugPanelView($webDebugToolbar));

    }
}
