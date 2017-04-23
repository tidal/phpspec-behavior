Feature: Developer generates an interface
  As a Developer
  I want to automate creating interfaces
  In order to avoid repetitive tasks and interruptions in development flow
  So when I type 'phpspec behavior:implement NonExistingInterface' in the console
  I want a non existing Interface to be generated

  Background: Assumptions
    Given command 'implement' exists in namespace 'behavior'
    And I select command 'implement' in namespace 'behavior'
    Given selected command has argument 'interface'
    Given selected command has argument 'trait'
    Given selected command has option 'force'
    Given the interface "Reflector" does exist
    Given the interface "CodeGeneration/TestInterface" does not exist

  @smoke
  Scenario: Getting an error without providing an interface
    Given I provide no arguments
    When I execute the command
    Then I get an error

  @interaction
  Scenario: Getting not prompted when providing an existing interface
    Given I provide argument 'interface' with value "Reflector"
    When I execute the command
    Then I do not get prompted

  @smoke
  Scenario: Getting no error when providing an existing interface
    Given I provide argument 'interface' with value "Reflector"
    When I execute the command
    Then I get no error

  @interaction
  Scenario: Getting prompted for generating an interface
    Given I provide argument 'interface' with value "CodeGeneration/TestInterface"
    When I execute the command
    Then I get prompted

  @smoke
  Scenario: Getting no error when rejecting interface generation
    Given I provide argument 'interface' with value "CodeGeneration/TestInterface"
    And I get prompted and answer no
    When I execute the command
    Then I get no error

  @interaction
  Scenario: Getting not prompted when using option 'force'
    Given I provide argument 'interface' with value "CodeGeneration/TestInterface"
    And I use option 'force'
    When I execute the command
    Then I do not get prompted

  @smoke
  Scenario: Getting no error when using option 'force'
    Given I provide argument 'interface' with value "CodeGeneration/TestInterface"
    And I use option 'force'
    When I execute the command
    Then I get no error


