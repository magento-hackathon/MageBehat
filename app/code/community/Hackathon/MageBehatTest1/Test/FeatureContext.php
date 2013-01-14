<?php

class Hackathon_MageBehatTest1_Test_FeatureContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    /**
     * @Then /^I should be able to click a poll$/
     */
    public function iShouldBeAbleToClickAPoll()
    {
        $this->getSession()->getDriver()->click('Price Rules');
        $this->getSession()->getDriver()->click('Vote');

    }
}