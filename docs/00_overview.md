# gohan-log 設計概要（確定版）

ダイエット中の人が、食事を写真とカロリー付きで記録し、ダイエットレシピを共有できるアプリ。
この設計書は Week 21 で見直して確定させた。

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
| 技術選定資料 | [06_tech-selection.md](06_tech-selection.md) |
| スプリント計画 | [sprint-plan.md](sprint-plan.md) |

## 技術構成
- Laravel 12・Blade（ルートは routes/web.php）、ログインは Breeze
- MySQL 8.4（本番は RDS）
- 開発環境は Docker、本番は AWS（EC2・RDS）
- デプロイ先：**A（AWS を使い続ける）**

## 制約
- 実装期間は 10月24日〜30日（10月31日は予備と提出）
- 見積もりに余裕が少ないため、遅れたら Should の機能を後回しにする（詳しくは sprint-plan.md の「遅れたときの判断」）
- 画像は EC2 内の storage に保存する（S3 は余裕があれば対応）