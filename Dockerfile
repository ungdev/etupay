FROM larueli/php-base-image:7.2

USER 0

ENV APACHE_DOCUMENT_ROOT="/var/www/html/public"

COPY . /var/www/html/
RUN echo "cd /var/www/html && /usr/local/bin/php artisan migrate --force" > /docker-entrypoint-init.d/a_migrations.sh && \
    ./composer install --no-interaction --no-dev --no-ansi && \
    chmod g+rwx -R /var/www/html

USER 675654
