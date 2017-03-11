#!/usr/bin/env bash
docker-compose down
nohup docker-compose up > /dev/null 2>&1 &