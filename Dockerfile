FROM raffiihza/docker-laravel

WORKDIR /usr/app
COPY . .

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    composer install && npm install && npm run build && \
    a2enmod proxy && a2enmod proxy_http && a2enmod rewrite && \
    mkdir -p /usr/app/storage /usr/app/cache && \
    chmod -R 777 /usr/app/storage /usr/app/cache && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2ctl", "-D", "FOREGROUND"]