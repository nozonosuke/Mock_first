# Mock First - フリマアプリ

## 概要

Laravelを用いて作成したフリマアプリです。

ユーザーは以下のことが可能です：

- 会員登録 / ログイン
- 商品出品
- 商品購入（1商品につき1回のみ購入可能）
- マイページ閲覧
- お気に入り登録
- コメント投稿

---

## 使用技術

- PHP 8.x
- Laravel 8.x
- MySQL
- Docker

---

## ER図

![ER図](docs/er_diagram.png)

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
