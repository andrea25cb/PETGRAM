# Usa una imagen base de PHP y Apache
FROM php:7.4-apache

# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copia los archivos del proyecto Laravel al contenedor
COPY . /var/www/html

# Instala las dependencias de PHP
RUN apt-get update \
    && apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
    && a2enmod rewrite

# Configura el documento raíz del servidor Apache
RUN sed -i -e 's/html/html\/public/g' /etc/apache2/sites-available/000-default.conf

# Habilita la reescritura de URL en el servidor Apache
RUN a2enmod rewrite

# Expone el puerto 80 para acceder al servidor Apache
EXPOSE 80

# Comando de entrada para iniciar el servidor Apache
CMD ["apache2-foreground"]
