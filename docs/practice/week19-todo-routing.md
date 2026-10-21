# 練習課題3：ToDoアプリのルーティング設計

ログインしたユーザーが、自分のタスクを登録・管理するアプリ。

| 画面・操作 | メソッド | URL | ルート名 | コントローラー@アクション | ログイン | 権限（Policy） |
|---|---|---|---|---|---|---|
| タスク一覧（状態で絞り込み） | GET | /tasks?status=done | tasks.index | TaskController@index | 必要 | - |
| タスク作成フォーム | GET | /tasks/create | tasks.create | TaskController@create | 必要 | - |
| タスクの保存 | POST | /tasks | tasks.store | TaskController@store | 必要 | - |
| タスク詳細 | GET | /tasks/{task} | tasks.show | TaskController@show | 必要 | 自分のタスクだけ |
| タスク編集フォーム | GET | /tasks/{task}/edit | tasks.edit | TaskController@edit | 必要 | 自分のタスクだけ |
| タスクの更新 | PUT | /tasks/{task} | tasks.update | TaskController@update | 必要 | 自分のタスクだけ |
| タスクの削除 | DELETE | /tasks/{task} | tasks.destroy | TaskController@destroy | 必要 | 自分のタスクだけ |
| 完了・未完了の切り替え（Ajax） | PATCH | /tasks/{task}/toggle | tasks.toggle | TaskController@toggle | 必要 | 自分のタスクだけ |

## 補足
- ログイン・ログアウト・会員登録は Breeze のルートを使う
- ToDo は自分専用なので、一覧も含めて全画面でログインが必要。詳細も他人には見せないため Policy で守る
- 完了・未完了の切り替えは画面を返さず、JSON（`{ "completed": true }`）を返す。一覧のチェックボックスから呼び、ページを再読み込みせずに表示を切り替える