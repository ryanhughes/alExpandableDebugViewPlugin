Adds expanding/collapsing controls for objects inside the Symfony 1.4 debug view panel

Currently only supports Doctrine_Collection & Doctrine_Record objects

## Install

Extract plugin under the symfony `plugins/` dir and add

```php
$this->enablePlugins('alExpandableDebugViewPlugin');
```

to `config/ProjectConfiguration.class.php` setup method