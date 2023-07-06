FROM registry.macellan.net/docker-images/php-nginx:8.1-bullseye

WORKDIR /var/www/html
COPY --chown=www-data:www-data . .
COPY .docker/laravel-queue.conf /etc/supervisor/conf.d/laravel-queue.conf

RUN npm ci
RUN npm run production
RUN composer install --no-dev

RUN chown -R :www-data /var/www/html/storage/ \
                       /var/www/html/bootstrap/cache/ && \
    chmod -R 777 /var/www/html/storage/ \
                 /var/www/html/bootstrap/cache/

RUN mv .docker/docker-entrypoint /usr/local/bin/docker-entrypoint && \
    chmod o+x /usr/local/bin/docker-entrypoint

CMD ["docker-entrypoint"]
