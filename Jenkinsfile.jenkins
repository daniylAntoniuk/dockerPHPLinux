#!groovy
//  groovy Jenkinsfile
properties([disableConcurrentBuilds()])

pipeline  {
    agent { 
        label 'master'
        }
    options {
        buildDiscarder(logRotator(numToKeepStr: '10', artifactNumToKeepStr: '10'))
        timestamps()
    }
    stages {

		stage("Create docker image") {
            steps {
                echo 'Creating docker image ...'
                dir('.'){
                  sh "docker-compose up -d"
                }
            }
        }       
    }
}