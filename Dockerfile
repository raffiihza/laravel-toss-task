FROM php:8.3

WORKDIR /app
COPY . .

RUN apt-get update && apt-get install -y git unzip curl && \
    curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    composer install && \
    curl https://frankenphp.dev/install.sh | sh && \
    curl https://i.jpillora.com/caddy && \
    mkdir -p /app/storage /app/cache && \
    chmod -R 777 /app/storage /app/cache && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 80
CMD ["./frankenphp", "run"]