#!/bin/sh
#
# 環境ごとの.env
#
# Please update below varoables as per your production setup
PARAMATER="${1}"
REGION="ap-northeast-1"

# mac対策(macならこれ。windowsはわからん)
LF=$'\\\x0A'

# Get parameters and put it into .env file inside application root
aws --profile zzzzzz ssm get-parameter --with-decryption --name $PARAMATER --region $REGION --query Parameter.Value | sed -e 's/^"//' -e 's/"$//' -e 's/\\n/'"$LF"'/g' -e 's/\\//g' > ../.env
