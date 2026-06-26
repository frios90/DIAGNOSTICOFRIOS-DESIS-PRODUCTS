# Dockerfile
FROM php:8.3-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]