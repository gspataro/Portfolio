#!/usr/bin/env bash

ENV_FILE = "../.env"

if [ "$1" == "stage" ]; then
    ENV_FILE = "../.env.stage"
fi

if [ ! -f ".env" ]; then
  echo "$ENV_FILE file not found"
  exit 1
fi

source "$ENV_FILE"

rsync -avL --delete ../contents/ "$SSH_USER@$SSH_HOST:$SSH_DIR/contents"
