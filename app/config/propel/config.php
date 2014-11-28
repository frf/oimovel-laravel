<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('oimovel', 'pgsql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
  'dsn' => 'pgsql:host=localhost;dbname=oimovel',
  'user' => 'oimovel',
  'password' => 'oimovel',
));
$manager->setName('oimovel');
$serviceContainer->setConnectionManager('oimovel', $manager);
$serviceContainer->setDefaultDatasource('oimovel');