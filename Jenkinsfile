pipeline {
    agent any

    // Define environment variables for easy path referencing
    environment {
        // --- UPDATE THESE PATHS ---
        PHP_EXE = 'C:/xampp/php/php.exe' 
        PYTHON_EXE = 'C:/Python312/python.exe' // Use your actual Python executable path
        
        // Output path for combined JUnit reports
        JUNIT_REPORT_PATH = 'build/logs/*.xml'
    }

    stages {
        stage('Checkout Code') {
            steps {
                echo "Starting CI for job ${env.JOB_NAME} build ${env.BUILD_NUMBER}"
            }
        }
        
        stage('Install Dependencies') {
            steps {
                // CORRECTED: Using 'bat' for Windows directory creation
                bat 'mkdir build\\logs'
                
                // CORRECTED: Using 'bat' to run the Composer executable path
                bat "${PHP_EXE} vendor\\bin\\composer update --no-dev" 
            }
        }
        
        stage('Unit Tests (PHP)') {
            steps {
                // CORRECTED: Using 'bat' to run the PHP executable path
                bat "${PHP_EXE} vendor\\bin\\phpunit -c phpunit.xml --log-junit build\\logs\\unit_junit.xml"
            }
        }
        
        stage('E2E Tests (Selenium)') {
            steps {
                // CORRECTED: Using 'bat' to run the Python executable path
                bat "${PYTHON_EXE} -m pytest e2e_tests/ --junitxml=build\\logs\\e2e_junit.xml"
            }
        }
    }
    
    post {
        // Actions to run regardless of stage success/failure
        always {
            // CRITICAL: This step reads ALL XML reports and publishes them to the Jenkins dashboard
            junit JUNIT_REPORT_PATH
            
            // JIRA Integration Message
            echo "Publishing test results to dashboard and updating JIRA..."
        }
        failure {
            echo 'Build FAILED! Check console output for PHP or Python errors.'
        }
        success {
            echo 'All tests passed. Pipeline completed successfully.'
        }
    }
}