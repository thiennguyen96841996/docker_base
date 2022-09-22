FROM node:18-bullseye-slim

WORKDIR /usr/src/app

ENV TZ Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY files/init.sh /usr/local/init.sh
COPY files/webpack.sh /usr/local/webpack.sh
RUN chmod 777 /usr/local/init.sh
# RUN chmod 777 /usr/local/webpack.sh
