## アプリケーション名
coachtechフリマ

## 環境構築

### Dockerビルド
1. git clone git@github.com:mako-12/fleamarket-app.git
2. DockerDesktopアプリを立ち上げる
3. docker-compose up -d --build

### Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. cp .env.example .env
 - 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
 - php artisan key:generate
6. マイグレーションの実行
 - php artisan migrate
7. シーディングの実行
 - php artisan db:seed


## 使用技術(実行環境)
- PHP 7.4.9
- Laravel 8.75
- MySQL 8.0.26
- nginx 1.21.1
- Docker 28.3.2
- docker-compose
- MailHog

## ER図
<img width="1111" height="821" alt="Image" src="https://github.com/user-attachments/assets/d1d7fa8d-25df-4454-ac58-44916b7c2a6d" />

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/

