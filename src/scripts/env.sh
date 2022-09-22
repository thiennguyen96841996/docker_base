#!/bin/bash
# インスタンスメタデータを取得して、自身のインスタンスIDを取得する。
export INSTANCE_ID=$(curl -s http://169.254.169.254/latest/meta-data/instance-id)

# aws-cli の describe-instances でインスタンスIDを指定して情報を取得する。
TAG=$(aws ec2 describe-instances --region ap-northeast-1 --instance-ids "${INSTANCE_ID}" --query 'Reservations[0].Instances[0].Tags[?Key==`env`]|[0].Value')

case $TAG in
    '"development"' ) ENV="DEV" ;;
    '"staging"' ) ENV="STG" ;;
    '"production"' ) ENV="PROD" ;;
esac

RESOURCE=`aws ssm get-parameter --region ap-northeast-1 --name "${ENV}_ENV_GUNDAM" --query "Parameter.Value" --with-decryption`
echo -e $RESOURCE |sed s/\"/''/ >> .env
mv .env /var/www/