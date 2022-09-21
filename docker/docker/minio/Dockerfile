FROM minio/minio:latest

EXPOSE 9000
EXPOSE 9001

ENTRYPOINT ["/opt/bin/minio", "server", "/data", "--console-address", ":9001"]
