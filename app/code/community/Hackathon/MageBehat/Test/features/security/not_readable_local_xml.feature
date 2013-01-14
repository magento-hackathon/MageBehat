Feature: local.xml is not readable

  Scenario: local.xml is not readable
    Given I am on "/app/etc/local.xml"
    Then I should get a "403" status

  Scenario: config.xml is not readable
    Given I am on "/app/etc/config.xml"
    Then I should get a "403" status
