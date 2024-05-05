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

①クローン先のディレクトリに移動後、以下のコマンドを実行してください。<br>
◇初期設定<br>
   git clone git@github.com:ishinagakazuyuki/ProTest_20240505.git<br>
   cd ProTest_20240505<br>
   docker-compose up -d --build<br>
   docker-compose exec php bash<br>
   composer install<br>
   composer -V<br>
   cp .env.example .env<br>
   composer require stripe/stripe-php<br>
   php artisan key:generate<br>
   php artisan storage:link<br>
   exit<br>
   sudo chmod -R 777 *<br>
   <br>
②.envファイルを以下の通りに修正してください。<br>
◇修正<br>
   DB_HOST=mysql<br>
   DB_DATABASE=laravel_db<br>
   DB_USERNAME=laravel_user<br>
   DB_PASSWORD=laravel_pass<br>
   <br>
   MAIL_FROM_ADDRESS=hello@example.com<br>
   <br>
◇追加<br>
   STRIPE_KEY="pk_test_51OIxl4IvhPYinHV0oio7tzICY0iGzWe2KNnXgu4Ss6RhyBvr20bhqRsg27hvSYZxM6IvJJsjrn4jo8Ln0PiPPF42007MtXePQG"<br>
   STRIPE_SECRET="sk_test_51OIxl4IvhPYinHV083T4Rcf6DaT7ZhB1bqiXoG5ao2SEaHZX2RDQGBk2lctaJy3sJBFAXjV60nUgFTEEr5Gw5iT500WIYGmmES"<br>
   <br>
③テーブルのリフレッシュと店舗・ジャンル・地域データの追加<br>
   cd ProTest_20240505<br>
   docker-compose exec php bash<br>
   php artisan migrate:fresh<br>
   php artisan db:seed<br>
   exit<br>
   <br>
④画像ファイルの配置<br>
   cd ProTest_20240505<br>
   mkdir src/storage/app/public/images<br>
   sudo chmod -R 777 src/storage/app/public/images<br>
   <br>
   ProTest_20240505 ディレクトリに存在する「imageset.zip」を解凍し、<br>
   その中にある以下の画像ファイルを src/storage/app/public/images に格納してください。<br>
   ・イタリアン.jpg<br>
   ・ラーメン.jpg<br>
   ・寿司.jpg<br>
   ・居酒屋.jpg<br>
   ・焼肉.jpg<br>
   ・key.png<br>
   ・mail.png<br>
   ・user.png<br>
   <br>
⑤サイトへのアクセス<br>
   ログインURL：http://localhost/login<br>
   管理者：manage@example.com<br>
   パスワード：password123<br>
   一般ユーザー：common@example.com<br>
   パスワード：password123<br>
   <br>
⑥管理者用画面（CSVインサート用）<br>
   URL：http://localhost/manage<br>
   <br>
⑥インサート用CSVファイルの内容<br>
   店舗名,地域,ジャンル,店舗情報,画像のURL<br>
   （例）<br>
   天下無双,東京都,ラーメン,日本全国どのラーメン屋よりもうまいラーメンを提供しています。その味は正に天下無双です。,https://cdn.pixabay.com/photo/2017/04/04/00/36/ramen-2199962_1280.jpg<br>
