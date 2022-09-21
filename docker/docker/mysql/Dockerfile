FROM mysql:8-debian

WORKDIR /var/lib/mysql

ENV TZ Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY files/conf/my.cnf  /etc/mysql/conf.d/my.cnf
COPY files/sql/init.sql /docker-entrypoint-initdb.d
