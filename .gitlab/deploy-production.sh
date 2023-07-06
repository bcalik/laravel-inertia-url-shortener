#!/bin/bash

set -e

SERVER_IP=${1}
IMAGE_TAG=${2}
SERVICE_NAME=${3}

echo "Updating service on IP ${SERVER_IP} with new image ${IMAGE_TAG}"

ssh -T -o StrictHostKeyChecking=no deploy@${SERVER_IP} << EOF
    docker pull registry.macellan.net/macellan/macellan-short:${IMAGE_TAG}
    docker pull registry.macellan.net/macellan/macellan-short:latest
    docker service update --force --image registry.macellan.net/macellan/macellan-short:${IMAGE_TAG} ${SERVICE_NAME}
EOF

echo "Done."
