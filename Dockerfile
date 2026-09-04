FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p database
RUN touch database/database.sqlite
RUN chmod 777 database/database.sqlite
RUN chmod -R 777 storage bootstrap/cache

RUN php artisan migrate --force

RUN php artisan tinker --execute="App\Models\User::create(['name' => 'Admin', 'email' => 'admin@easybuy.com', 'password' => Illuminate\Support\Facades\Hash::make('password'), 'role' => 'admin', 'email_verified_at' => now()])"

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]