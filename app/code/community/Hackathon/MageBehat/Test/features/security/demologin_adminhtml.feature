Feature: Index Page
  As a website administrator
  I want to see the index page
  So that I can understand what the website offers and how it can benefit me

  Scenario: Display Header
    Given I am on "/admin"
    When I fill in "login[username]" with "admin"
    And I fill in "login[password]" with "admin123" 
    And I press "Login"
    Then I should see text "Invalid User Name or Password."
