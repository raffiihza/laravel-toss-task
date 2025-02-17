FROM raffiihza/docker-laravel

WORKDIR /var/www/html
COPY . .

ENV APP_ENV=production

RUN composer install && npm install && npm run build
RUN mkdir -p /var/www/html/storage /var/www/html/cache && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2ctl", "-D", "FOREGROUND"]