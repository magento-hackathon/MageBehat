Feature: Home Page
  As a website visitor
  I want to see the homepage
  So that I can understand what the website offers and how it can benefit me

  Scenario: Contact Us link is hidden when disabled
  Given I set config value for "contacts/contacts/enabled" to "0" in "default" scope
  And the cache is clean
  When I am on "/"
  Then I should not see text "Contact Us"

  Scenario: Display Welcome Message
  Given I am on "/"
  Then I should see text "test1"
