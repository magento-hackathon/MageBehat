Feature: Checkout
  As a Customer using a commerce website
  I want to be able to buy Products

  @javascript
  Scenario: Add Product to Cart
    Given I am on "/chair.html"
    When I press "Add to Cart"
    And I should see text "Chair was added to your shopping cart."
    And I should see text "Proceed to Checkout"
    Then I press "Proceed to Checkout"
    And I should see text "Checkout Method"
    When I check "checkout_method"
    When I press Button with onclick "checkout.setMethod();"
    Then I should see text "Ship to this address"
    When I fill in "billing[firstname]" with "firstname"
    When I fill in "billing[lastname]" with "lastname"
    When I fill in "billing[company]" with "company"
    When I fill in "billing[email]" with "test@test.com"
    When I fill in "billing[street][]" with "street 1"
    When I fill in "billing[city]" with "city"
    When I select "1" from "billing[region_id]"
    When I fill in "billing[postcode]" with "12345"
    When I fill in "billing[telephone]" with "555-12345678890"
    When I fill in "billing[fax]" with "555-0987654321"
    When I press Button with onclick "billing.save()"
    And I wait for "5" Seconds
    Then I should see text "Flat Rate"
    When I press Button with onclick "shippingMethod.save()"
    And I wait for "5" Seconds
    Then I should see text "Check / Money order"
    When I check "payment[method]"
    When I press Button with onclick "payment.save()"
    And I wait for "5" Seconds
    Then I should see text "Product Name"
    When I press Button with onclick "review.save();"
    And I wait for "10" Seconds
    Then I should see text "Your order has been received."
