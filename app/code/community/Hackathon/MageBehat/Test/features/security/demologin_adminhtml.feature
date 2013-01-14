Feature: Unsafe admin login

  Scenario: Display Header
    Given I am on "/admin"
    When I fill in "login[username]" with "admin"
    And I fill in "login[password]" with "admin123" 
    And I press "Login"
    Then I should see text "Invalid User Name or Password."
