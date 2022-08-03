#!/bin/bash

# Install composer

sudo apt update -y
sudo apt install wget php-cli php-zip unzip -y

wget -O composer-setup.php https://getcomposer.org/installer

sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Install docker

sudo apt-get update -y
sudo apt-get install \
    ca-certificates \
    curl \
    gnupg \
    lsb-release -y

curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update -y
sudo apt-get install docker-ce docker-ce-cli containerd.io -y

# Install docker-compose

sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

# Install CodeDeploy Agent

sudo apt-get update -y
sudo apt-get install ruby-full -y
sudo apt-get install wget -y

wget https://aws-codedeploy-us-east-1.s3.us-east-1.amazonaws.com/latest/install

chmod +x ./install
sudo ./install auto

# Install extensions PHP

sudo apt-get install -y php-curl
sudo apt-get install -y php-simplexml

# Install collectD

sudo apt install collectd -y

# Download & Install CloudWatch agent 

wget https://s3.us-east-1.amazonaws.com/amazoncloudwatch-agent-us-east-1/debian/amd64/latest/amazon-cloudwatch-agent.deb
sudo dpkg -i -E ./amazon-cloudwatch-agent.deb
wget https://s3.amazonaws.com/server.configs/cloudwatch-agent-config.json
sudo /opt/aws/amazon-cloudwatch-agent/bin/amazon-cloudwatch-agent-ctl -a fetch-config -m ec2 -s -c file:cloudwatch-agent-config.json