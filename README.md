# Rese（リーズ）

- ある企業のグループ会社の飲食店予約サービス。

![toppage](https://github.com/ishinagakazuyuki/Rese_Develop/assets/135584828/bed870d9-50dc-4c52-81ed-94b2d7905e70)

## 作成した目的

- 模擬案件を通して、自分自身の力量を確かめるため。

## 機能一覧

- 会員登録
- ログイン・ログアウト
- ユーザー認証メール送信
- 検索機能（都道府県・ジャンル・店舗名）
- お気に入り設定・削除機能
- 予約設定・変更・削除機能
- ユーザーごとのお気に入り・予約情報取得
- ユーザーによる店舗評価機能
- stripeによる決済機能
- QRコードによる予約情報の照合機能
- リマインダー送信（午前9:00にメール自動送信）
- 店舗代表者用ページ（店舗情報設定・修正、予約情報メール送信）
- 管理者用ページ（店舗代表者登録）

## 使用技術(実行環境)

- Laravel Framework 8.83.27
- PHP 7.4.9 (cli) (built: Sep  1 2020 02:33:08) ( NTS )
- MySQL Ver 8.0.26 for Linux on x86_64
- nginx 1.21.1
- phpMyAdmin　5.2.1
- mailhog

## テーブル設計

![table drawio](https://github.com/ishinagakazuyuki/Rese_Develop/assets/135584828/2ee02bf9-5361-4712-b000-3667902d1ddd)

## ER 図

![ER drawio](https://github.com/ishinagakazuyuki/Rese_Develop/assets/135584828/ae80e449-50c2-4daf-b319-1c11b70c60f8)

## 環境構築

- クローン先のディレクトリに移動後以下のコマンドを実行してください。
git clone git@github.com:ishinagakazuyuki/Rese_Develop.git
cd Rese_Develop
docker-compose up -d --build
docker-compose exec php bash
apt-get update
apt-get install libgd-dev
docker-php-ext-install gd
composer install
cp .env.example .env
exit

- .envファイルを以下の通りに修正してください。
 ★修正
APP_KEY=base64:BAj4pL5V23zX6lP08LVux0pfO7/H01CKtjoGhCzrtaU=

DB_HOST=mysql
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

MAIL_FROM_ADDRESS=hello@example.com

★追加
STRIPE_KEY="pk_test_51OIxl4IvhPYinHV09qPDHTXQ21jNeHCNoAuaVEbVQcaFH7auzpezaD2n469QfxrUfdheHJ0XkgLpM7fqsiu4mcwa00P7zLVu7Q"
STRIPE_SECRET="sk_test_51OIxl4IvhPYinHV0A9h8mw1MqJL7zklZOOya70C9f82x9vfXWTTmuhGBFUgKFok0ydFqT2rqTRCA6yE29zy0RBmC00NquRxzFu" 
