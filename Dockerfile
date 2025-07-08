FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libzip-dev \
    gnupg

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql zip

# Instalar Node.js 20 (requerido por Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Copiar Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cambiar DocumentRoot a public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias y construir frontend
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# Asignar permisos a Laravel
RUN chown -R www-data:www-data storage bootstrap/cache
