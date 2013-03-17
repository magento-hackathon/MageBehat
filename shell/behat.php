<?php

use \Symfony\Component\Console\Input\StringInput;

require_once 'abstract.php';

define('BEHAT_PHP_BIN_PATH', getenv('PHP_PEAR_PHP_BIN') ?: '/usr/bin/env php');
define('BEHAT_BIN_PATH',     __FILE__);
define('BEHAT_VERSION',      'DEV');

class Mage_Shell_Behat extends Mage_Shell_Abstract
{
    const BY_MAGE_MODULE = '--by-mage-module';

    public function run()
    {
        require(BP.'/lib/autoload.php');
        $this->_validate();
        $this->_init();

        try {
            foreach (Mage::getConfig()->loadModules()->getNode('modules')->children() as $moduleName => $module) {
                $featureDir = Mage::getConfig()->getModuleDir('', $moduleName) . DS . 'Test' . DS . 'features';
                $runBehat = false;
                //only run behat once we have found at least one feature file
                if (is_dir($featureDir)) {
                    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($featureDir)) as $file) {
                        if (pathinfo($file->getFilename(), PATHINFO_EXTENSION) == 'feature') {
                            $runBehat = true;
                            break;
                        }
                    }
                }

                if ($runBehat) {
                    //TODO: work out a way to pass this through the application
                    Mage::register('magebehat/current_module', $moduleName);
                    $app = new Behat\Behat\Console\BehatApplication(BEHAT_VERSION);
                    $input = new StringInput($this->getArgs($moduleName).$featureDir);
                    $app->setAutoExit(false);
                    $app->run($input);
                    Mage::unregister('magebehat/current_module');
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    protected function getArgs($moduleName)
    {
        $args = $_SERVER['argv'];
        array_shift($args); //name of script itself
        $argString = implode(' ', $args);
        if (strpos($argString, self::BY_MAGE_MODULE) !== false) {
            $argString = str_replace(self::BY_MAGE_MODULE, '', $argString);
            if (strpos($argString, '--out') !== false) {
                $argString = str_replace('--out=', '--out=var' . DS . 'behat' . DS . $moduleName, $argString);
            } else {
                $argString .= ' --out=var' . DS . 'behat' . DS . $moduleName;
            }
        }
        if (sizeof($argString) > 0) {
            $argString .= ' ';
        }
        return $argString;
    }

    protected function _init()
    {
        $varBehatFolder = Mage::getBaseDir('var') . DS . 'behat';
        Mage::getConfig()->getOptions()->createDirIfNotExists($varBehatFolder);
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

  -h            Short alias for help
  help          This help
  --by-mage-module

  Behat Arguments
  --init
  -f|--format="..."
  --out="..."
  --lang="..."
  --[no-]ansi
  --[no-]time
  --[no-]paths
  --[no-]snippets
  --[no-]snippets-paths
  --[no-]multiline
  --[no-]expand
  --story-syntax
  -d|--definitions="..."
  --name="..."
  --tags="..."
  --cache="..."
  --strict
  --dry-run
  --rerun="..."
  --append-snippets

USAGE;
    }
}

$shell = new Mage_Shell_Behat();
$shell->run();