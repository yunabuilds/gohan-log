# ルーティング設計

## ルート一覧
| 画面・操作 | メソッド | URL | ルート名 | コントローラー@アクション | ログイン | 権限（Policy） | 画面 |
|---|---|---|---|---|---|---|---|
| トップ | GET | / | - | （/posts へリダイレクト） | 不要 | - | - |
| 投稿一覧 | GET | /posts | posts.index | PostController@index | 不要 | - | 01 |
| 投稿詳細 | GET | /posts/{post} | posts.show | PostController@show | 不要 | - | 02 |
| 投稿作成フォーム | GET | /posts/create | posts.create | PostController@create | 必要 | - | 03 |
| 投稿の保存 | POST | /posts | posts.store | PostController@store | 必要 | - | - |
| 投稿編集フォーム | GET | /posts/{post}/edit | posts.edit | PostController@edit | 必要 | 自分の投稿だけ | 04 |
| 投稿の更新 | PUT | /posts/{post} | posts.update | PostController@update | 必要 | 自分の投稿だけ | - |
| 投稿の削除 | DELETE | /posts/{post} | posts.destroy | PostController@destroy | 必要 | 自分の投稿だけ | - |
| マイページ（日付で絞り込み） | GET | /mypage?date=2026-10-21 | mypage | MyPageController@index | 必要 | - | 05 |
| お気に入り一覧 | GET | /favorites | favorites.index | FavoriteController@index | 必要 | - | 06 |
| お気に入り登録・解除（Ajax） | POST | /posts/{post}/favorite | posts.favorite | FavoriteController@toggle | 必要 | - | - |

## 補足
- ログイン・ログアウト・会員登録の画面は、Breeze が作るルートを使う
- ログイン後・会員登録後は、投稿一覧（/posts）に移動する
- 投稿一覧は1ページ12件のページネーション（/posts?page=2）
- マイページは、日付を指定しないときは今日の日付で絞り込む
- 権限の「自分の投稿だけ」は、PostPolicy の update・delete で確認する

## Ajax のルート
お気に入り登録・解除（POST /posts/{post}/favorite）は、画面を返さず JSON を返す。
投稿一覧と投稿詳細の ♡ ボタンから呼び、ページを再読み込みせずに ♡ の状態と件数を書き換える。

レスポンス例：
```json
{ "favorited": true, "count": 4 }
```

## 照らし合わせ
| 確認すること | 結果 |
|---|---|
| ユーザーストーリー1〜10が、どれかのルートで実現できるか | 1：Breeze、2：store、3：index・show、4：favorite、5：edit・update、6：destroy、7：Policy、8・9：mypage、10：store（材料・作り方を入力） |
| Figma の画面と GET のルートが対応しているか | 01〜06 すべてに GET のルートがある |
| 他人のデータを編集・削除できるルートがないか | edit・update・destroy を Policy で守る |
| Ajax のルートが1つ以上あるか | お気に入り登録・解除 |