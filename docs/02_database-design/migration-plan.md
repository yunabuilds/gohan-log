# マイグレーション計画

外部キーで参照される側（親）のテーブルから順に作る。

| 順 | テーブル | 作り方 |
|---|---|---|
| 1 | users | Breeze の標準マイグレーションをそのまま使う |
| 2 | posts | `php artisan make:migration create_posts_table`（users を参照） |
| 3 | favorites | `php artisan make:migration create_favorites_table`（users と posts を参照） |

- 写真を表示するため、`php artisan storage:link` を実行する
- 本番（RDS）への反映は、デプロイ時に `php artisan migrate --force` で行う