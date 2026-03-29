# アプリケーション名

fleamarket

## 環境構築

Dockerビルド
・git clone git@github.com:yuki-nakagawa-1021/fleamarket.git
・docker-compose up -d --build

### Laravel環境構築

・docker-compose exec php bash
・composer install
・cp .env.example .env
・php artisan key:generate
・php artisan migrate
・php artisan db:seed

## メール認証について

本アプリではメール認証にMailHogを使用しています。
認証メールは実際のメールアドレスには送信されず、MailHog上で確認できます。

MailHog : http://localhost:8025

## Stripe設定

APIキーの設定は各自でお願いします。

## 開発環境

・商品一覧画面（トップ画面）：http://localhost/
・商品一覧画面（マイリスト）：http://localhost/?tab=mylist
・会員登録画面：http://localhost/register
・ログイン画面：http://localhost/login
・商品詳細画面：http://localhost/item/{item_id}
・商品購入画面：http://localhost/purchase/{item_id}
・送付先住所変更画面：http://localhost/purchase/address/{item_id}
・商品出品画面：http://localhost/sell
・プロフィール画面：http://localhost/mypage
・プロフィール編集画面：http://localhost/mypage/profile
・プロフィール画面（購入した商品一覧）：http://localhost/mypage?page=buy
・プロフィール画面（出品した商品一覧）：http://localhost/mypage?page=sell
・phpMyAdmin：http://localhost:8080/
・MailHog：http://localhost:8025

## 使用技術（実行環境）

・PHP 8.2.30
・Laravel 8.83.29
・mysql 8.0.26
・nginx 1.21.1
・MailHog
・Stripe
・JavaScript

## 主な機能

・会員登録 / ログイン / ログアウト機能
・メール認証機能
・商品一覧表示
・マイリスト一覧表示
・商品検索機能
・商品詳細表示
・いいね機能
・コメント機能
・商品購入機能
・配送先変更機能
・プロフィール表示 / 編集機能
・商品出品機能

## ER図

## URL

開発環境：http://localhost/
