#!/bin/bash
set -e

docker login registry.macellan.net
docker build -t registry.macellan.net/macellan/macellan-short:latest .
docker push registry.macellan.net/macellan/macellan-short:latest
