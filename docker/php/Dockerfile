FROM php:8.2-fpm-bookworm

# Installer dépendances système minimales pour Symfony
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libxslt-dev \
    zlib1g-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

# Installer Symfony CLI (facultatif mais pratique)
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Installer extensions PHP nécessaires à Symfony
RUN docker-php-ext-configure intl && \
    docker-php-ext-install \
        intl \
        pdo \
        pdo_mysql \
        zip \
        opcache \
        mbstring \
        xsl \
        dom

WORKDIR /var/www
