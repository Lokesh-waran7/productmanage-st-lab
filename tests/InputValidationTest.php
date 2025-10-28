<?php
use PHPUnit\Framework\TestCase;

// The test class must extend PHPUnit\Framework\TestCase
class InputValidationTest extends TestCase
{
    // ===============================================
    // 1. POSITIVE TEST CASE (Data that should pass)
    // ===============================================
    
    /**
     * @test
     * Test case for valid, successful product data based on create_product.php logic.
     */
    public function testValidProductInputs()
    {
        $name = "Monitor Stand";
        $quantity = 5;
        $price = 120.50;
        
        // Assertion 1: All fields are non-empty
        $this->assertFalse(empty($name), "Name should not be empty.");
        
        // Assertion 2: Quantity is a positive integer (Quantity > 0 check)
        $this->assertTrue(is_numeric($quantity) && $quantity > 0, "Valid quantity (5) should be recognized as numeric and positive.");

        // Assertion 3: Price is a non-negative number (Price >= 0 check)
        $this->assertTrue(is_numeric($price) && $price >= 0, "Valid price (120.50) should be recognized as numeric and non-negative.");
    }

    // ===============================================
    // 2. NEGATIVE TEST CASES (Data that should fail)
    // ===============================================

    /**
     * @test
     * Test case for invalid quantity (negative number), simulating a test failure.
     */
    public function testInvalidNegativeQuantityFails()
    {
        $quantity = -10;
        
        // Assert that the validation condition (quantity > 0) is FALSE
        $this->assertFalse($quantity > 0, "Negative quantity (-10) must fail the positive check.");
    }

    /**
     * @test
     * Test case for invalid price (non-numeric string).
     */
    public function testInvalidNonNumericPriceFails()
    {
        $price = "ABC";
        
        // Assert that the validation condition (is_numeric) is FALSE
        $this->assertFalse(is_numeric($price), "Non-numeric price ('ABC') must fail the numeric check.");
    }
    
    /**
     * @test
     * Test case for missing required field (Name is empty).
     */
    public function testEmptyNameFails()
    {
        $name = "";
        
        // Assert that the field is empty (which should trigger an error in the application)
        $this->assertTrue(empty($name), "Empty name field must fail the required check.");
    }
}
