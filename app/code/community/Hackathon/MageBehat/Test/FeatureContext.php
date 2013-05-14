<?php

use MageTest\MagentoExtension\Context\MagentoContext as MagentoContext;

use Behat\Mink\Exception\ExpectationException;

use Behat\MinkExtension\Context\RawMinkContext,
    Behat\MinkExtension\Context\MinkContext;

use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Exception\ErrorException;

/**
 * Features context.
 */
class Hackathon_MageBehat_Test_FeatureContext extends MagentoContext {

    public function __construct(array $parameters)
    {

        $moduleName = Mage::registry('magebehat/current_module');
        $dir = \Mage::getConfig()->getModuleDir('', $moduleName);
        if ($moduleName != 'Hackathon_MageBehat') {
            $className = $moduleName . '_Test_FeatureContext';
            $fileName = $dir . DS . 'Test' . DS . 'FeatureContext.php';
            if (file_exists($fileName)) {
                require_once($fileName);
                $subcontext = new $className();
                if (!$subcontext instanceof RawMinkContext) {
                    throw new ErrorException(E_USER_ERROR, 'Please extend your feature context directly from \Behat\MinkExtension\Context\RawMinkContext', $fileName, 0);
                }
                if ($subcontext instanceof MinkContext) {
                    throw new ErrorException(E_USER_ERROR, 'Definitions of MinkContext are already loaded please extend your feature context directly from \Behat\MinkExtension\Context\RawMinkContext', $fileName, 0);
                }
                $this->useContext('subcontext', $subcontext);
            }
        }

    }
    /**
     * @Given /^I log in as admin user "([^"]*)" identified by "([^"]*)"$/
     */
    public function iLoginAsAdmin($username, $password)
    {
        $sid = $this->getSessionService()->adminLogin($username, $password);
        $this->getSession()->setCookie('adminhtml', $sid);
    }

    /**
     * @Given /^I am logged in as admin user "([^"]*)" identified by "([^"]*)"$/
     */
    public function iAmLoggedInAsAdminUserIdentifiedBy($username, $password)
    {
        $this->getSession()->visit($this->locatePath('/admin'));

        if (false === strpos(parse_url($this->getSession()->getCurrentUrl(), PHP_URL_PATH), '/admin/dashboard/')) {
            $this->getSession()->getPage()->fillField('login[username]', $username);
            $this->getSession()->getPage()->fillField('login[password]', $password);
            $this->getSession()->getPage()->pressButton('Login');
        }

        $this->assertSession()->addressMatches('#/admin/dashboard/.+$#');
    }


    /**
     * @When /^I open admin URI "([^"]*)"$/
     */
    public function iOpenAdminUri($uri)
    {
        $urlModel = new \Mage_Adminhtml_Model_Url();
        if (preg_match('@^/admin/(.*?)/(.*?)((/.*)?)$@', $uri, $m)) {
            $processedUri = "/admin/{$m[1]}/{$m[2]}/key/".$urlModel->getSecretKey($m[1], $m[2])."/{$m[3]}";
            $this->getSession()->visit($this->locatePath($processedUri));
        } else {
            throw new \InvalidArgumentException('$uri parameter should start with /admin/ and contain controller and action elements');
        }
    }

    /**
     * @Then /^I should see text "([^"]*)"$/
     */
    public function iShouldSeeText($text)
    {
        $this->assertPageContainsText($text);
    }

    /**
     * @Then /^I should not see text "([^"]*)"$/
     */
    public function iShouldNotSeeText($text)
    {
        $this->assertPageNotContainsText($text);
    }

    /**
     * @Given /^I set config value for "([^"]*)" to "([^"]*)" in "([^"]*)" scope$/
     */
    public function iSetConfigValueForScope($path, $value, $scope)
    {
        $this->getConfigManager()->setCoreConfig($path, $value, $scope);
    }


    /**
     * @Given /^the cache is clean$/
     */
    public function theCacheIsClean()
    {
        $this->getCacheManager()->clear();
    }

    /**
     * @Given /the following products exist:/
     */
    public function theProductsExist(TableNode $table)
    {
        $hash = $table->getHash();
        $fixtureGenerator = $this->getFixtureFactory()->create('product');
        foreach ($hash as $row) {
            $row['stock_data'] = array();
            if (isset($row['is_in_stock'])) {
                $row['stock_data']['is_in_stock'] = $row['is_in_stock'];
                unset($row['is_in_stock']);
            }
            if (isset($row['qty'])) {
                $row['stock_data']['qty'] = $row['qty'];
                unset($row['qty']);
            }
            $row['website_ids'] = array(1);
            $fixtureGenerator->create($row);
        }
    }

    /**
     * @When /^I press Button with onclick "([^"]*)"$/
     */
    public function iPressButtonWithOnclick($arg1)
    {
        $this->getSession()->getDriver()->click('//button[@onClick="'.$arg1.'"]');
    }

    /**
     * @When /^I press input field with onclick "([^"]*)"$/
     */
    public function iPressInputWithOnclick($arg1)
    {
        $this->getSession()->getDriver()->click('//input[@onClick="'.$arg1.'"]');
    }

    /**
     * @Given /^I wait for "([^"]*)" Seconds$/
     */
    public function iWaitForSeconds($arg1)
    {
        sleep($arg1);
    }

    /**
     * @Then /^I should get a "([^"]*)" status$/
     */
    public function iShouldGetAStatus($expectedCode)
    {
        $actualCode = $this->getSession()->getDriver()->getStatusCode();
        if ($actualCode != $expectedCode) {
            $message = sprintf('Current page returned "%s", but "%s" expected.', $actualCode, $expectedCode);
            throw new ExpectationException($message, $this->getSession());
        }
    }
}
