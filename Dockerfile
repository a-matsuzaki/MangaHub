# ベースとなるイメージを指定
FROM php:8.1-fpm

# 必要なライブラリのインストール
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libzip-dev \
  zip \
  unzip \
  git

# PHPの拡張機能のインストール
RUN docker-php-ext-install pdo pdo_mysql gd zip exif pcntl

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# アプリケーションのコードをコンテナにコピー
COPY . /var/www/html

# 作業ディレクトリを指定
WORKDIR /var/www/html

# Composerを使って依存関係をインストール
RUN composer install --no-dev --optimize-autoloader

# ポートを公開
EXPOSE 9000

# PHP-FPMを起動
CMD ["php-fpm"]
