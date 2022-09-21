# 2022/04/26: redis:6.2-bullseyeだとなぜが6.0系が入る…
FROM redis:6.2-alpine3.15

RUN apk --no-cache add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata

EXPOSE 6379

# 2022/04/26: confを渡すと起動しなくなる為、オプションで対応
ENTRYPOINT ["redis-server", "--bind 0.0.0.0", "--maxmemory 10mb", "--maxmemory-policy allkeys-lru"]
