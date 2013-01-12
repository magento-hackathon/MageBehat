Feature: Home Page
  As a website visitor
  I want to see the homepage
  So that I can understand what the website offers and how it can benefit me

   Scenario: Display Logo
     Given I am on "home page"
     Then I should see "Magento Logo"

  Scenario: Contact Us link is shown when active
  Given I set config value for "contacts/contacts/enabled" to "1" in "default" scope
  And the cache is clean
  When I am on "/"
  Then I should see text "test2"
