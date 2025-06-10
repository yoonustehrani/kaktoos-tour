FROM node:18-alpine AS base

# npm install
FROM base AS static-builder
RUN apk add --no-cache libc6-compat
WORKDIR /app
# Install dependencies based on the preferred package manager
# yarn.lock* pnpm-lock.yaml*
COPY package.json package-lock.json* ./
RUN \
  if [ -f package-lock.json ]; then npm ci; \
  else echo "Lockfile not found."; \
  fi
COPY . .
RUN \
  if [ -f package-lock.json ]; then npm run build; \
  else echo "Lockfile not found."; \
  fi

# Serving the app
FROM dunglas/frankenphp:1-php8.4-bookworm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN install-php-extensions \
    intl \
    pcntl \
    ctype \
    curl \
    dom \
    fileinfo \
    filter \
    hash \
    mbstring \
    openssl \
    pcre \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    session \
    tokenizer \
    xml \
    redis \
    zip
 
COPY . /app

COPY .env.production /app/.env

WORKDIR /app

COPY --from=static-builder /app/public/build ./public/build

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --optimize-autoloader --no-dev

RUN php artisan optimize
RUN php artisan filament:optimize

RUN apt-get update -y && apt-get install -y supervisor

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
