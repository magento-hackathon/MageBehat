<?php

require_once 'abstract.php';

class Mage_Shell_Behat extends Mage_Shell_Abstract
{
    public function run()
    {
        $this->_validate();
        try {
            foreach (Mage::getConfig()->loadModules()->getNode('modules')->children() as $moduleName => $module) {
                $featureDir = Mage::getConfig()->getModuleDir('', $moduleName) . DS . 'Test' . DS . 'features';
                foreach (new DirectoryIterator($featureDir) as $featureFile) {
                    echo $featureFile . PHP_EOL;
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }


    protected function _validate()
    {
        if (!Mage::helper('core')->isDevAllowed()) {
            exit('You are not allowed to run this script.');
        }

        return true;
    }

    public function getArg($name)
    {
        $arg = parent::getArg($name);
        if (false === $arg && isset($_GET[$name])) {
            $arg = $_GET[$name];
        }

        return $arg;
    }

    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f shell/behat.php -- [options]

  -r            Output renderer (default is php_sapi_name())
  -h            Short alias for help
  help          This help

USAGE;
    }
}

$shell = new Mage_Shell_Behat();
$shell->run();