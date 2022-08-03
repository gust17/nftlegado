#!/bin/bash

cd /nft && sudo docker-compose up -d && rm nft.tar
ls
sudo chmod 777 ./src/application/cache
sudo chmod 777 ./src/uploads
sudo chmod 777 ./src/uploads/comprovantes