# Flea Market App - フリマアプリ

## 概要

Laravelを用いて作成したフリマアプリです。

---

## 環境構築
### Dockerビルド

```bash
git clone git@github.com:nozonosuke/Mock_first.git
docker-compose up -d --build
```

### Laravel環境構築
```bash
docker-compose exec php bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```
---

## 環境構築時の注意点

- 本アプリはDockerを使用しています。
- DB接続エラー（Connection refused）が発生した場合は、
`.env` の DB 設定が Docker のサービス名と一致しているかを確認してください。

### 例（docker-compose 使用時）
DB_HOSTには `localhost` や `127.0.0.1` ではなく、 
`docker-compose.yml` に定義されている **MySQL のサービス名（例：mysql）** を指定します。

---

## 使用技術（実行環境）
- PHP 8.1
- Laravel 8.x（8.83.29）
- MySQL 8.0.26
- Nginx 1.21.1
- Docker / Docker Compose
- Git / GitHub

---

## ER図
![ER Diagram](docs/er_diagram.png)

※本アプリは1商品につき1回のみ購入可能な設計とし、
purchases.item_id に UNIQUE制約を付与しています。

---

## ディレクトリ構成
```bash
mock_first/
├── docker/
├── docs/
│   └── er_diagram.png
└── src/
    ├── app/
    ├── database/
    ├── resources/
    └── routes/
```
---

## 機能一覧
### 認証機能
- Laravel Fortifyを使用
- 会員登録（メール認証対応）
- ログイン / ログアウト
- 認証制御（未ログイン時アクセス制限）

### 商品管理機能
- 商品一覧表示（おすすめ / マイリスト切替）
- キーワード検索機能
- 商品詳細表示
- 商品出品機能（カテゴリ選択可）
- 商品購入機能（1商品につき1購入）
- 配送先編集機能

### マイページ機能
- ユーザー情報表示
- プロフィール編集
- 出品商品一覧表示
- 購入履歴一覧表示

### インタラクション機能
- お気に入り登録 / 解除
- コメント投稿 / 表示

---

## URL
### 開発環境

- 商品一覧画面（トップ画面）： http://localhost/
- 商品一覧画面（トップ画面）_マイリスト：http://localhost/?tab=mylist
- 会員登録画面：http://localhost/register
- ログイン画面：http://localhost/login
- 商品詳細画面： `/item/{item_id}` （例：/item/1）
- 商品購入画面： `/purchase/{item_id}` （例：/purchase/1）
- 住所変更ページ： `/address/{item_id}` （例：/address/1）
- 商品出品画面：http://localhost/sell
- プロフィール画面：http://localhost/mypage
- プロフィール編集画面：http://localhost/mypage/profile
- プロフィール画面_購入した商品一覧：http://localhost/mypage?page=buy
- プロフィール画面_出品した商品一覧：http://localhost/mypage?page=sell

---

## テスト用アカウント

- メールアドレス：test@example.com
- パスワード：password

## 単体テスト実行方法

Dockerコンテナ内で以下を実行してください。

```bash
docker-compose exec php bash
php artisan test
```
---

## 主な設計ポイント
### 1商品1購入制御

- purchases.item_id に UNIQUE制約を付与
- ER図上でも ITEMS ||--|| PURCHASES にて1対1を明示

---

## 起動方法
```bash
docker-compose up -d
php artisan migrate
php artisan db:seed
```
