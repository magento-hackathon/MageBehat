Feature: No license or release_note files in the root

  Scenario: No LICENSE.txt
    Given I am on "/LICENSE.txt"
    Then I should get a "404" status

  Scenario: No LICENSE.html
    Given I am on "/LICENSE.html"
    Then I should get a "404" status

  Scenario: No LICENSE_AFL.txt
    Given I am on "/LICENSE_AFL.txt"
    Then I should get a "404" status

  Scenario: No RELEASE_NOTES.txt
    Given I am on "/RELEASE_NOTES.txt"
    Then I should get a "404" status
