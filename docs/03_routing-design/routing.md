# ルーティング設計

## ルート一覧

印の意味：🔒 = Policy で守るルート（自分の投稿だけ）、⚡ = Ajax のルート（JSON を返す）、（S）= Should の機能

### 認証（Breeze が作るルート）
| 画面・操作 | メソッド | URL | ルート名 | ログイン | 画面 |
|---|---|---|---|---|---|
| 会員登録画面 | GET | /register | register | 不要 | Breeze |
| 会員登録 | POST | /register | - | 不要 | - |
| ログイン画面 | GET | /login | login | 不要 | Breeze |
| ログイン | POST | /login | - | 不要 | - |
| ログアウト | POST | /logout | logout | 必要 | - |

### 投稿・マイページ・お気に入り
| 画面・操作 | メソッド | URL | ルート名 | コントローラー@アクション | ログイン | 権限（Policy） | 画面 |
|---|---|---|---|---|---|---|---|
| トップ | GET | / | - | （/posts へリダイレクト） | 不要 | - | - |
| 投稿一覧 | GET | /posts | posts.index | PostController@index | 不要 | - | 01 |
| 投稿作成フォーム | GET | /posts/create | posts.create | PostController@create | 必要 | - | 03 |
| 投稿の保存 | POST | /posts | posts.store | PostController@store | 必要 | - | - |
| 投稿詳細 | GET | /posts/{post} | posts.show | PostController@show | 不要 | - | 02 |
| 🔒 投稿編集フォーム | GET | /posts/{post}/edit | posts.edit | PostController@edit | 必要 | 自分の投稿だけ | 04 |
| 🔒 投稿の更新 | PUT | /posts/{post} | posts.update | PostController@update | 必要 | 自分の投稿だけ | - |
| 🔒 投稿の削除 | DELETE | /posts/{post} | posts.destroy | PostController@destroy | 必要 | 自分の投稿だけ | - |
| マイページ（日付で絞り込み） | GET | /mypage?date=2026-10-21 | mypage | MyPageController@index | 必要 | - | 05 |
| お気に入り一覧 | GET | /favorites | favorites.index | FavoriteController@index | 必要 | - | 06 |
| ⚡ お気に入り登録・解除 | POST | /posts/{post}/favorite | posts.favorite | FavoriteController@toggle | 必要 | - | - |

### 体重の記録（Should）
| 画面・操作 | メソッド | URL | ルート名 | コントローラー@アクション | ログイン | 権限（Policy） | 画面 |
|---|---|---|---|---|---|---|---|
| （S）体重の記録フォーム | GET | /weights/create | weights.create | WeightController@create | 必要 | - | 07 |
| （S）体重の保存 | POST | /weights | weights.store | WeightController@store | 必要 | - | - |

## 補足
- ログイン・ログアウト・会員登録は、Breeze が作るルートをそのまま使う
- ログイン後・会員登録後は、投稿一覧（/posts）に移動する
- 投稿のルートは `Route::resource('posts', PostController::class)` で作る。index・show 以外は auth ミドルウェアでログインを必須にする
- `/posts/create` は `/posts/{post}` より先に定義する（`create` が投稿IDと間違われないようにするため。Route::resource では自動でこの順になる）
- 投稿一覧は1ページ12件のページネーション（/posts?page=2）
- マイページは、日付を指定しないときは今日の日付で絞り込む。1日の合計カロリー（Should）と体重の記録の一覧（Should）もマイページに表示する
- 🔒 の「自分の投稿だけ」は、PostPolicy の update・delete で確認する。他の人の投稿の場合は 403 エラーにする
- 体重の記録は、ログイン中のユーザーの記録だけを保存・表示する（auth()->id() で絞り込むため、Policy は使わない）
- 画面07（体重の記録）は Should のため、Figma では作っていない。作る場合は投稿作成画面（03）と同じレイアウトにする

## Ajax のルート
お気に入り登録・解除（POST /posts/{post}/favorite）は、画面を返さず JSON を返す。
投稿一覧と投稿詳細の ♡ ボタンから呼び、ページを再読み込みせずに ♡ の状態と件数を書き換える。
自分の投稿も他の人の投稿もお気に入りできる。

レスポンス例：
```json
{ "favorited": true, "count": 4 }
```

- POST のため、リクエストには CSRF トークン（X-CSRF-TOKEN ヘッダー）を付ける
- ログインしていない場合は 401 を返し、画面側でログイン画面に移動する

## 照らし合わせ
| 確認すること | 結果 |
|---|---|
| ユーザーストーリー1〜11が、どれかのルートで実現できるか | 1：Breeze、2：store、3：index・show、4：favorite・favorites.index、5：edit・update、6：destroy、7：Policy（🔒）、8・9：mypage、10：store（材料・作り方を入力）、11：weights.create・weights.store・mypage |
| Figma の画面と GET のルートが対応しているか | 01〜06 すべてに GET のルートがある（07 は Should のため Figma なし） |
| 他人のデータを編集・削除できるルートがないか | edit・update・destroy を Policy（🔒）で守る。体重は自分の記録だけを扱う |
| Ajax のルートが1つ以上あるか | お気に入り登録・解除（⚡） |