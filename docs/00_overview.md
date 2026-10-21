# gohan-log 設計概要（初版）

ダイエット中の人が、食事を写真とカロリー付きで記録し、ダイエットレシピを共有できるアプリ。
この設計書は Week 21 で見直して確定させる。

## 設計書の一覧
| 設計書 | ファイル |
|---|---|
| 要件定義書 | [requirements.md](requirements.md) |
| 画面設計（Figma・画面遷移図） | [01_screen-design/figma.md](01_screen-design/figma.md) |
| テーブル定義書・ER図 | [02_database-design/table-definitions.md](02_database-design/table-definitions.md) |
| マイグレーション計画 | [02_database-design/migration-plan.md](02_database-design/migration-plan.md) |
| ルーティング設計 | [03_routing-design/routing.md](03_routing-design/routing.md) |
| 工数見積もり | [04_estimation/workload.md](04_estimation/workload.md) |
| スケジュール | [04_estimation/schedule.md](04_estimation/schedule.md) |
| インフラ構成図 | [05_infrastructure/infrastructure.md](05_infrastructure/infrastructure.md) |

## 技術構成
- Laravel・Blade（ルートは routes/web.php）、ログインは Breeze
- MySQL（本番は RDS）
- 開発環境は Docker、本番は AWS（EC2・RDS）
- デプロイ先：**A（AWS を使い続ける）**

## 制約
- 実装期間は 10月26日〜31日の約6日間
- 見積もりに余裕が少ないため、遅れたら Should の機能を後回しにする
- 画像は EC2 内の storage に保存する（S3 は余裕があれば対応）