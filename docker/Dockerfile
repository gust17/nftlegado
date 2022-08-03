FROM webdevops/php-nginx:7.4-alpine

COPY ./docker/nginx/10-location-root.conf /opt/docker/etc/nginx/vhost.common.d/10-location-root.conf
# COPY ./nginx/10-location-root.conf /opt/docker/etc/nginx/vhost.common.d/10-location-root.conf


COPY ./src /app

RUN chmod 755 /app/application/cache
RUN chmod 755 /app/application/logs
RUN chmod 755 /app/uploads
RUN chmod 755 /app/uploads/comprovantes

EXPOSE 80