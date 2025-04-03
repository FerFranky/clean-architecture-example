# 1️⃣ Usa una imagen oficial de PHP con extensiones necesarias
FROM php:8.4-fpm

# 2️⃣ Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    zip unzip curl git libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# 3️⃣ Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Configura el usuario para evitar problemas de permisos
RUN useradd -ms /bin/bash laravel
USER laravel

# 5️⃣ Establece el directorio de trabajo
WORKDIR /var/www

# 6️⃣ Expone el puerto para FPM
EXPOSE 9000

CMD ["php-fpm"]
