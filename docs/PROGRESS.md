# 開発進捗

> **ゴール（MVP）:** ブラウザでタスクの追加・一覧・編集・完了・削除ができる Todo アプリ
> **進め方:** コードは自分で書く。Claude は解説・ヒント・レビュー担当
> **使い方:** 作業開始時に `/start`、終了時に `/end`

## 📍 現在地
- **進捗:** 約 60%（ステップ 0〜4 完了、5 はほぼ完了）
- **今いるステップ:** 5. 入力チェック（バリデーションは動いた。メッセージが英語）
- **次の一歩:** バリデーションのメッセージを日本語にする
- **やりかけ:** updated_at の実験（何も変えずに `save()` すると updated_at はどうなるか）※任意

## 🗺️ ロードマップ
| # | ステップ | 状態 | 重さ | 主に学ぶこと |
|---|---|---|---|---|
| 0 | 環境構築（PHP、Laravel Boost、SQLite） | ✅ | ― | WSL、artisan |
| 1 | テーブル作成 | ✅ | 小 | DB の基本、マイグレーション |
| 2 | モデルでデータ操作 | ✅ | 小 | PHP の基本、Eloquent、tinker |
| 3 | 一覧表示 | ✅ | **大** | ルーティング、コントローラー、Blade |
| 4 | 追加 | ✅ | 中 | フォーム、POST、CSRF |
| 5 | 入力チェック | 🔶 | 小 | バリデーション |
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
- 文が入れ子になると `;` も複数必要（`return ...;` と `});`）
- URL（`'/tasks'`）とビュー名（`'tasks.index'`）は別もの。ビュー名に `/` は付けない
- コントローラー内では `App\Models\Task` が namespace のせいで見つからない → `use App\Models\Task;` を書く
- ルートの `[TaskController::class, 'index']` の 'index' はメソッド名と一致させる
- `Route::get('/tasks/create', ...)` の URL に `GET ` を書かない（GET は `Route::get` で指定済み）→ 書くと 404。404 が出たら `php artisan route:list`
- `view()` の2つ目は、渡すデータがあるときだけ書く
- HTML の属性は、その設定を付けたい要素の開始タグに書く（`method` / `action` は `<form>` に）。`<form>` を `<for>` と打ち間違えてもエラーにならない
- 変数は `new` で作ってから使う（`$task = new Task;` を忘れると Undefined variable）
- `Parse error: unexpected ...` は、エラーの出た行の**1つ前の行**の `;` 忘れを疑う
- `validate()` のキーは入力欄の `name`（`'title'`）
- id=1 のタスクの due_date が `2026-9-30`（0 なし）で保存されている → フォーム作成時に正しい形式で保存する仕組みを入れる

## 🔧 環境メモ
- プロジェクトは WSL 側の `~/dev/todo-app`（2026-10-01 に Windows 側から引っ越し。表示が約 4 秒 → 0.3 秒に）
- 開き方: PowerShell で `wsl` → `cd ~/dev/todo-app` → `code .`（VS Code を WSL モードで開く）/ `claude`
- 旧フォルダ `C:\Users\merot\dev\laravel-app\task-manager` はバックアップとして残してある（使わない）
- `~/dev/task-manager` は 9 月に Sail で作った別のプロジェクト（触らない）
- PHP は `~/.config/herd-lite/bin`（php.new で導入）。DB は SQLite（`database/database.sqlite`）
- スマホでは OneDrive アプリの `task-manager/PROGRESS.md` で見られる（Claude の応答が終わるたびに自動で同期される）
- タイムゾーンは `Asia/Tokyo`（id=1 のタスクは変更前に UTC で保存されたもの）

---

# 📓 作業日誌

## 2026-10-01
### やったこと
- ブラウザの `/tasks/create` からタスク（スクワット100回）を追加し、DB に保存されて一覧に表示されることを確認 → **ステップ4 完了**
- 空のまま送信して `NOT NULL constraint failed: tasks.title` エラーを確認（マイグレーションのルールが DB を守った）
- レッスン8: バリデーション。`$request->validate(['title' => 'required|max:255'])` と `@error('title')` で、フォーム画面にエラーメッセージ（英語）を表示できた
  - つまずき: `validate([...])` の後の `;` 忘れ（エラーは次の行で報告される）、キーに入力欄の name ではなく表示用の文言を書いた
- 表示が遅い（約 4 秒）原因が「WSL から Windows 側のファイルを読む遅さ」と判明 → プロジェクトを `~/dev/todo-app` に引っ越し（約 0.3 秒に）

### 次にやること
- バリデーションのメッセージを日本語にする → ステップ5 完了

## 2026-09-30
### やったこと
- 復習クイズ: 連想配列でビューに変数を渡す仕組み、`{{ }}` のエスケープを確認
- レッスン6: コントローラー（クラス、メソッド、`public function`、namespace と use）
  - `php artisan make:controller TaskController` で作成し、`index` メソッドに一覧表示の処理を移した
  - ルートを `[TaskController::class, 'index']` に書き換えた → **ステップ3 完了**
  - つまずき: メソッドで包み忘れ、`App\Models\Task` の namespace、ルートのメソッド名の不一致 → すべて自分で修正

- ステップ4（追加）の実装
  - レッスン7: GET と POST の違い（GET で送ると入力内容が URL に付くことを実験で確認）、フォーム、`@csrf`
  - `GET /tasks/create`（`create` メソッド + `create.blade.php`）でフォーム画面を表示できた
  - `POST /tasks` と `store` メソッド（`new Task` → `$request->input('title')` → `save()` → `redirect('/tasks')`）を書いた。**ブラウザでの動作確認はまだ**
  - `new` の意味（設計図から実物を作る）、`::` と `->` の違いを学んだ

### 次にやること
- ブラウザからタスクを追加して動作確認 → 一覧に「追加」へのリンクを付ける → ステップ5（入力チェック）

## 2026-09-29
### やったこと
- 復習クイズ: カラム名・型・nullable を正しく答えられた。NULL と空文字・0 の違いを確認
- レッスン4: ルーティング（リクエストとレスポンス、`Route::get`、`php artisan serve`）
  - `/tasks` のルートを自分で追加し、文字列 → `Task::all()`（JSON）→ ビューの順に返してみた
- レッスン5: ビュー（Blade）
  - `resources/views/tasks/index.blade.php` を作成し、ルートから `['tasks' => Task::all()]` で渡したタスクを `@foreach` と `{{ }}` で一覧表示できた
- （開発外）応募書類の開発経験・自己PRを作成

### 次にやること
- コントローラーを作り、ルートの処理を引っ越す（ステップ3 完了）

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
