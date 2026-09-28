# 開発進捗

> **ゴール（MVP）:** ブラウザでタスクの追加・一覧・編集・完了・削除ができる Todo アプリ
> **進め方:** コードは自分で書く。Claude は解説・ヒント・レビュー担当
> **使い方:** 作業開始時に `/start`、終了時に `/end`

## 📍 現在地
- **進捗:** 約 20%（ステップ 0〜2 完了）
- **今いるステップ:** 3. 一覧表示 の直前
- **次の一歩:** ルーティングの基本を学び、`/tasks` にアクセスしたら何か表示されるようにする
- **やりかけ:** updated_at の実験（何も変えずに `save()` すると updated_at はどうなるか）

## 🗺️ ロードマップ
| # | ステップ | 状態 | 重さ | 主に学ぶこと |
|---|---|---|---|---|
| 0 | 環境構築（PHP、Laravel Boost、SQLite） | ✅ | ― | WSL、artisan |
| 1 | テーブル作成 | ✅ | 小 | DB の基本、マイグレーション |
| 2 | モデルでデータ操作 | ✅ | 小 | PHP の基本、Eloquent、tinker |
| 3 | 一覧表示 | ⬜ | **大** | ルーティング、コントローラー、Blade |
| 4 | 追加 | ⬜ | 中 | フォーム、POST、CSRF |
| 5 | 入力チェック | ⬜ | 小 | バリデーション |
| 6 | 編集 | ⬜ | 中 | ルートパラメータ、PUT/PATCH |
| 7 | 完了 / 未完了の切り替え | ⬜ | 小 | 更新の応用 |
| 8 | 削除 | ⬜ | 小 | DELETE |
| 9 | 見た目を整える | ⬜ | 小〜中 | Tailwind CSS |

**％の目安:** 0〜2 で 20% / 3 で 45% / 4〜5 で 60% / 6 で 75% / 7〜8 で 90% / 9 で 100%

**MVP の後にやりたいこと（任意）:** テスト、Factory / Seeder、ログインしてユーザーごとの Todo

## 🧠 つまずきメモ（復習用）
- 「カラム名」と「型」を混同しやすい。例: カラム名 `is_completed`、型は boolean
- カラム名などの文字列は `' '` で囲む。囲まないと `Undefined constant` エラー
- `nullable()`（空を許す）と `default()`（初期値）は別の指示

## 🔧 環境メモ
- PowerShell で `wsl` と打って Ubuntu に入り、`cd /mnt/c/Users/merot/dev/laravel-app/task-manager` で作業する
- PHP は `~/.config/herd-lite/bin`（php.new で導入）。DB は SQLite（`database/database.sqlite`）
- スマホでは OneDrive アプリの `task-manager/PROGRESS.md` で見られる（Claude の応答が終わるたびに自動で同期される）
- タイムゾーンは `Asia/Tokyo`（id=1 のタスクは変更前に UTC で保存されたもの）

---

# 📓 作業日誌

## 2026-09-28
### やったこと
- WSL での作業方法を確認した（PowerShell で `wsl` と打って Ubuntu に入る）
- レッスン1: データベースの基本（テーブル / カラム / レコード / 型 / NULL / default / 主キー）
- レッスン2: PHP の基本（マイグレーションを読むのに必要な範囲）
- `php artisan make:model Task -m` で Task モデルとマイグレーションを作成した
- マイグレーションに title / description / due_date / is_completed を自分で書き、`php artisan migrate` で tasks テーブルを作成した
  - 最初はカラム名を `' '` で囲み忘れた → 修正済み
- VS Code に Poimandres テーマを設定した
- レッスン3: tinker で Eloquent を体験した（`new` + `save()` で追加、`find()` で取得、変更して `save()` で更新、`all()` で全件取得）
  - boolean は SQLite では 0/1 で保存されることを確認した
  - created_at / updated_at は自動で入り、更新すると updated_at だけが変わることを確認した
- `config/app.php` の timezone を `Asia/Tokyo` に変更した
- 進捗の確認方法を整えた（このファイルの構成を変更、`/start` と `/end` コマンドを追加）
  - Claude Code 起動時に `/start` `/end` のリマインダーが表示されるようにした
  - このファイルが OneDrive（`OneDrive/task-manager/PROGRESS.md`）に自動コピーされ、スマホで見られるようにした

### 次にやること
- ルーティングとビューの基本 → タスク一覧ページを作る

## 2026-09-27
### やったこと
- プロジェクトの現状を確認した（独自機能は未実装、コミット0件）
- `docs/PROGRESS.md` を作成し、CLAUDE.md に進捗記録のルールを追記した
- php.new で PHP 8.5 / Composer 2.8 を WSL に導入した
- 初回コミットを作成した
- Laravel Boost 2.10 を導入した（guidelines / skills / MCP）
  - CLAUDE.md は `@AGENTS.md` で読み込む形に変更、`.mcp.json` を WSL 用に修正
- DB を SQLite に切り替えた
- 進め方を決めた: コードは自分で書き、Claude は解説・ヒント・レビュー担当（Claude が先に書いた Todo コードは破棄した）
