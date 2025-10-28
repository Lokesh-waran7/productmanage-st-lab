pipeline {
    agent any

    // Define environment variables for clean path referencing
    environment {
        // --- UPDATE THESE PATHS IF DIFFERENT ---
        PHP_EXE = 'C:/xampp/php/php.exe' 
        PYTHON_EXE = 'C:/Python312/python.exe' 
        
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
        // REMOVED: Bypassing unstable dependency installation
        echo 'Skipping dependency installation; using committed vendor folder.'
    }

        }
        
        stage('Unit Tests (PHP)') {
            steps {
                // Run PHPUnit tests
                bat "${PHP_EXE} vendor\\bin\\phpunit -c phpunit.xml --log-junit build\\logs\\unit_junit.xml"
            }
        }
        
        stage('E2E Tests (Selenium)') {
            steps {
                // Run Pytest (for Selenium)
                bat "${PYTHON_EXE} -m pytest e2e_tests/ --junitxml=build\\logs\\e2e_junit.xml"
            }
        }
    }
    
    post {
        always {
            // CRITICAL: This publishes the combined Unit and E2E results to the Jenkins dashboard
            junit JUNIT_REPORT_PATH
            
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