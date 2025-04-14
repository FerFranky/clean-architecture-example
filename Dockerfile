# 1️⃣ Usa una imagen oficial de PHP con extensiones necesarias
FROM php:8.4-fpm

# 2️⃣ Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    curl git libfreetype6-dev libjpeg-dev libpng-dev unzip zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3️⃣ Instala y configura Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug,coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=$(cat /etc/resolv.conf | grep nameserver | awk '{print $2}')" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini

# 4️⃣ Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5️⃣ Configura el usuario para evitar problemas de permisos
RUN useradd -ms /bin/bash laravel
USER laravel

# 6️⃣ Establece el directorio de trabajo
WORKDIR /var/www

# 7️⃣ Expone el puerto para FPM
EXPOSE 9000

CMD ["php-fpm"]
