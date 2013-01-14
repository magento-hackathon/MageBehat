Feature: Search
  As a Customer using a commerce website
  I want to be able to search for Products
  So that I can find the Product I am looking for quickly

  Scenario: Search for Product
    Given I am on "/"
    When I fill in "sony" to the search box
    And I press "Search"
    And the h1 should be "Search results for 'sony'"
    And I should not see text "Your search returns no results."
    And I should see the dropdown "Show x per page" dropdown
    And I should be able to view as grid or list
    And I should be able to "sort by relevance, name or price"
    And I should see an image, title, reviews, price, add to cart, add to wishlist, add to compare" 
