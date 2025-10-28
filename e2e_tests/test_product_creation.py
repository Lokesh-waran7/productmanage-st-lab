import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
import time
import random

# --- Configuration ---
# IMPORTANT: Adjust this URL to match your XAMPP folder name (e.g., /productmanage/)
BASE_URL = "http://localhost/productmanage/" 
# ---------------------

@pytest.fixture
def driver():
    """
    Pytest fixture to initialize the Chrome browser and handle cleanup.
    Assumes Chromedriver is accessible via system PATH or placed in the project directory.
    """
    # Initialize the Chrome driver
    d = webdriver.Chrome() 
    # Set an implicit wait time (good practice for stability)
    d.implicitly_wait(10) 
    
    # Run the actual test function
    yield d 
    
    # This runs after the test: Close the browser
    d.quit() 

def test_add_new_product_e2e(driver):
    """
    Tests the full end-to-end workflow of adding a product and verifying its presence.
    (CRUD: Create and Read operations).
    """
    # Generate a unique name to ensure the search is specific
    unique_id = str(random.randint(1000, 9999))
    product_name = f"E2E Automated Item {unique_id}"
    product_quantity = "10"
    product_price = "99.99"
    
    print(f"\nStarting E2E Test for product: {product_name}")
    
    # 1. Navigate to the main page
    driver.get(BASE_URL + "index.php")

    # 2. Click the 'Add New Product' link to go to the creation form
    try:
        add_link = driver.find_element(By.LINK_TEXT, "Add New Product")
        add_link.click()
    except Exception as e:
        pytest.fail(f"Could not find 'Add New Product' link. Check the HTML in index.php. Error: {e}")
    
    # 3. Input Test Data into the form
    print("Filling form data...")
    driver.find_element(By.NAME, "name").send_keys(product_name)
    driver.find_element(By.NAME, "quantity").send_keys(product_quantity)
    driver.find_element(By.NAME, "price").send_keys(product_price)

    # 4. Submit the form
    print("Submitting form...")
    driver.find_element(By.XPATH, "//input[@type='submit']").click()
    
    # 5. Verification (Read Operation)
    # The application should redirect to index.php. Verify the product is in the HTML table.
    
    try:
        # Search for the table cell (<td>) that contains the unique product name text
        verification_element = driver.find_element(By.XPATH, f"//td[text()='{product_name}']")
        
        # Assertion: Check if the element is found and displayed
        assert verification_element.is_displayed()
        print(f"PASSED: Product '{product_name}' successfully created and verified on inventory page.")
        
    except Exception:
        # If the element is not found, the test fails
        pytest.fail(f"FAILED: Product '{product_name}' was not found in the final inventory table. Check database connection and PHP insertion logic.")