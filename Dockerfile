# =========================
# 1️⃣ Node - Compilar assets
# =========================
FROM node:20-alpine AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY resources resources
COPY vite.config.js .
RUN npm run build

# =========================
# 2️⃣ PHP + Composer
# =========================
FROM php:8.2-fpm-alpine

# Dependencias del sistema
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    postgresql-dev \
    libpng-dev \
    libzip-dev

# Extensiones PHP necesarias
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    zip \
    gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar proyecto
COPY . .

# Copiar assets compilados
COPY --from=node /app/public/build public/build

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Permisos Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
