Feature: Manage users
  In order to manage users
  As a client software developer
  I need to be able to retrieve, create, update and delete them trough the API.

    # the "@createSchema" annotation provided by API Platform creates a temporary SQLite database for testing the API
  @createSchema
  Scenario: Create a restaurant user
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/users" with body:
    """
    {
      "email": "john.doe+restaurant@gmail.com",
      "plain_password": "unknown",
      "first_name": "John",
      "last_name": "Doe",
      "address": "27 rue du chemin Vert",
      "city": "Paris",
      "zip": 75011,
      "phone_number": "+33612345678",
      "is_restaurant": true
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "id": 1,
      "email": "john.doe+restaurant@gmail.com",
      "roles": [
          "ROLE_USER",
          "ROLE_RESTAURANT"
      ],
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "address": "27 rue du chemin Vert",
      "city": "Paris",
      "zip": 75011,
      "phone_number": "+33612345678"
    }
    """

  Scenario: Throw error when a user is already created
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/users" with body:
    """
    {
      "email": "john.doe+restaurant@gmail.com",
      "plain_password": "unknown",
      "first_name": "John",
      "last_name": "Doe",
      "address": "27 rue du chemin Vert",
      "city": "Paris",
      "zip": 75011,
      "phone_number": "+33612345678",
      "is_restaurant": true
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/problem+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "type": "https://tools.ietf.org/html/rfc2616#section-10",
      "title": "An error occurred",
      "detail": "email: Email already taken",
      "violations": [
        {
          "propertyPath": "email",
          "message": "Email already taken"
        }
      ]
    }
    """

  @dropSchema
  Scenario: Create a customer user
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/users" with body:
    """
    {
      "email": "john.doe+customer@gmail.com",
      "plain_password": "unknown",
      "first_name": "John",
      "last_name": "Doe",
      "address": "27 rue du chemin Vert",
      "city": "Paris",
      "zip": 75011,
      "phone_number": "+33612345678",
      "is_restaurant": false
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "id": 2,
      "email": "john.doe+customer@gmail.com",
      "roles": [
          "ROLE_USER",
          "ROLE_CUSTOMER"
      ],
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "address": "27 rue du chemin Vert",
      "city": "Paris",
      "zip": 75011,
      "phone_number": "+33612345678"
    }
    """