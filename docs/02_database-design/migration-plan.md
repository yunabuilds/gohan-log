# マイグレーション計画

外部キーで参照される側（親）のテーブルから順に作る。

| 順 | テーブル | 作り方 | 区分 |
|---|---|---|---|
| 1 | users | Breeze の標準マイグレーションをそのまま使う | Must |
| 2 | posts | `php artisan make:migration create_posts_table`（users を参照） | Must |
| 3 | favorites | `php artisan make:migration create_favorites_table`（users と posts を参照） | Must |
| 4 | weights | `php artisan make:migration create_weights_table`（users を参照） | Should |

- 1〜3 は MVP のため、スプリント1で作る
- 4 は Should のため、Must の機能がすべて終わってから作る
- posts の ingredients・steps（材料・作り方）は Should の機能だが、列は 2 で最初から作っておく