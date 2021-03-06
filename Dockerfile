FROM php:8.0-cli

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /usr/src/alignwebs

WORKDIR /usr/src/alignwebs

RUN composer install

# SET ENVIRONMENT VARIABLES
ENV WEATHER_API_KEY=""

CMD [ "php", "./run.php" ]