pipeline {
    agent any // Use any available executor on the Jenkins server

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
                // Jenkins automatically checks out the code configured in the job
                echo "Starting CI for job ${env.JOB_NAME} build ${env.BUILD_NUMBER}"
            }
        }
        
        stage('Install Dependencies') {
            steps {
                // Creates the report directory structure
                sh 'mkdir -p build/logs' 
                
                // Install/Update PHP dependencies (PHPUnit)
                sh "${PHP_EXE} vendor/bin/composer update --no-dev" 
            }
        }
        
        stage('Unit Tests (PHP)') {
            steps {
                // Run PHPUnit tests using the XML config and outputting the JUnit report
                sh "${PHP_EXE} vendor/bin/phpunit -c phpunit.xml --log-junit build/logs/unit_junit.xml"
            }
        }
        
        stage('E2E Tests (Selenium)') {
            steps {
                // Run Pytest (for Selenium) and output its JUnit report
                sh "${PYTHON_EXE} -m pytest e2e_tests/ --junitxml=build/logs/e2e_junit.xml"
            }
        }
    }
    
    post {
        // Actions to run regardless of stage success/failure
        always {
            // CRITICAL: This step reads ALL XML reports and publishes them to the Jenkins dashboard
            junit JUNIT_REPORT_PATH
            
            // JIRA Integration (This links the build status to the PROJ-101 ticket)
            echo "Publishing test results to dashboard and updating JIRA..."
            // (The specific JIRA update command depends on your plugin, but the report is the main proof)
        }
        failure {
            echo 'Build FAILED! Check console output for PHP or Python errors.'
        }
        success {
            echo 'All tests passed. Pipeline completed successfully.'
        }
    }
}