#!/usr/bin/env bash

ENV_FILE=".env"
BUILD_COMMAND="rebuild"

if [ "$1" == "stage" ]; then
    ENV_FILE=".env.stage"
    BUILD_COMMAND="stage:rebuild"
fi

if [ ! -f "$ENV_FILE" ]; then
  echo "$ENV_FILE file not found"
  exit 1
fi

source "$ENV_FILE"

ssh "$SSH_USER@$SSH_HOST" <<EOF
    cd "$SSH_DIR"
    composer run "$BUILD_COMMAND"
EOF
