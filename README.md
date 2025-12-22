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

MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="COACHTECH"
```
5. アプリケーションキーの作成
  php artisan key:generate
6. マイグレーションの実行
  php artisan migrate
7. シーディングの実行
  php artisan db:seed


## 使用技術(実行環境)
- PHP 7.4.9
- Laravel 8.75
- MySQL 8.0.26
- nginx 1.21.1
- Docker 28.3.2
- docker-compose
- MailHog

## テーブル仕様
### usersテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| name | varchar(255) |  |  |  |  |
| email | varchar(255) |  | ◯ | ◯ |  |
| email_verified_at | timestamp |  |  |  |  |
| password | varchar(255) |  |  | ◯ |  |
| remember_token | varchar(100) |  |  |  |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### profilesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| user_id | bigint |  |  | ◯ | users(id) |
| address_id | bigint |  |  | ◯ | addresses(id) |
| profile_image | varchar(255) |  |  |  |  |
| name | varchar(255) |  |  |  |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### addressesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| post_code | varchar(255) |  |  |  |  |
| address | varchar(255) |  |  |  |  |
| building | varchar(255) |  |  |  |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### itemsテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| profile_id | bigint |  |  | ◯ | profiles(id) |
| item_condition_id | bigint |  |  | ◯ | item_conditions(id) |
| item_image | varchat(255) |  |  | ◯ |  |
| name | varchar(255) |  |  | ◯ |  |
| brand | varchar(255) |  |  |  |  |
| detail | varchar(255) |  |  | ◯ |  |
| price | int |  |  | ◯ |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### item_conditionsテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| name | varchar(255) |  |  |  |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### item_categoriesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| name | varchar(255) |  |  |  |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### item_category_itemテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| item_category_id |  |  | ◯ | item_categories(id) |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### commentsテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| profile_id | bigint |  |  | ◯ | profiles(id) |
| content | varchar(255) |  |  | ◯ |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### favoritesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| profile_id | bigint |  |  | ◯ | profiles(id) |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### transactionsテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| buyer_profile_id | bigint |  |  | ◯ | profiles(id) |
| seller_profile_id | bigint |  |  | ◯ | profiles(id) |
| payment_method | tinyInteger |  |  | ◯ |  |
| status | tinyInteger |  |  | ◯ |  |
| completed_at | timestamp |  |  |  |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |

### evaluationsテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| transaction_id | bigint |  |  | ◯ | transactions(id) |
| evaluator_profile_id | bigint |  |  | ◯ | profiles(id) |
| evaluated_profile_id | bigint |  |  | ◯ | profiles(id) |
| rating | tinyInteger |  |  | ◯ |  |
| created_at | timestamp |  |  | ◯ |  |
| updated_at | timestamp |  |  | ◯ |  |
- UNIQUE(transaction_id, evaluator_profile_id)

### chat_messagesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| transaction_id | bigint |  |  | ◯ | transactions(id) |
| sender_profile_id | bigint |  |  | ◯ | profiles(id) |
| message | varchar(255) |  |  | ◯ |  |
| chat_image | varchar(255) |  |  |  |  |


## ER図
<img width="1081" height="770" alt="ProテストER図" src="https://github.com/user-attachments/assets/caec7286-0fab-47a3-ad9e-f87df1790b38" />

## テストアカウント

name: ユーザー１  
email: user1@example.com  
password: password  
-------------------------
name: ユーザー２  
email: user2@example.com  
password: password   
-------------------------
name: ユーザー３  
email: user3@example.com  
password: password  
-------------------------

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/


## 補足

- 会員登録のバリデーションについて
      機能要件ではFortifyを使用して会員登録を実装する前提になっていますが、
      FortifyにFortifyRegisterRequestが存在しないため、今回は app/Http/Request/RegisterRequest を作成しFormRequestを用いたバリデーションを採用しています。
      この構成により、登録時のバリデーションルールや、エラーメッセージを柔軟にカスタマイズできるようになっています。
      

- リダイレクト先の変更について
      会員登録後は'/mypage/profile'へリダイレクトされる仕様ですが、
      応用機能としてメール認証機能を追加している為、登録直後は'/email/verify'に遷移します。
      そのため、テストコード内のリダイレクト先も'/email/verify'に変更しています。


