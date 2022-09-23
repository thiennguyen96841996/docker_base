FROM nginx:1.21

WORKDIR /usr/src/app

ENV TZ Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY files/conf/nginx.conf                          /etc/nginx/nginx.conf
COPY files/conf/conf.d/00_default.conf              /etc/nginx/conf.d/00_default.conf
COPY files/conf/conf.d/01_customer.dev.glc.conf  /etc/nginx/conf.d/01_customer.dev.glc.conf
COPY files/conf/conf.d/02_client.dev.glc.conf    /etc/nginx/conf.d/02_client.dev.glc.conf
COPY files/conf/conf.d/03_master.dev.glc.conf     /etc/nginx/conf.d/03_master.dev.glc.conf
COPY files/ssl/_wild.dev.glc.crt.pem             /etc/nginx/ssl/_wild.dev.glc.crt.pem
COPY files/ssl/_wild.dev.glc.key.pem             /etc/nginx/ssl/_wild.dev.glc.key.pem
COPY files/ssl/dhparam.pem                          /etc/nginx/ssl/dhparam.pem

EXPOSE 80
EXPOSE 443

ENTRYPOINT ["nginx", "-g", "daemon off;"]
