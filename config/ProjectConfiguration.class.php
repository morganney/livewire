<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
  	// Opted not to use ORM 4/14/2010
    // $this->enablePlugins('sfDoctrinePlugin');
  }
}
