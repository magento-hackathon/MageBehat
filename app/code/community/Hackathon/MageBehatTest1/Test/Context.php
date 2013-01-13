<?php

class Hackathon_MageBehatTest1_Test_Context extends \Behat\MinkExtension\Context\RawMinkContext
{
    /**
     * @Then /^I should be able to click a poll$/
     */
    public function iShouldBeAbleToClickAPoll()
    {
        echo 'OK';
    }
}