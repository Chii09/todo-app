# 開発進捗

> **ゴール（MVP）:** ブラウザでタスクの追加・一覧・編集・完了・削除ができる Todo アプリ
> **進め方:** コードは自分で書く。Claude は解説・ヒント・レビュー担当
> **使い方:** 作業開始時に `/start`、終了時に `/end`

## 📍 現在地
- **進捗:** 約 90%（ステップ 0〜8 完了）
- **今いるステップ:** 9. 見た目を整える（一覧画面に Tailwind を適用中）
- **次の一歩:** 一覧の仕上げ（編集リンクの見た目、完了タスクに取り消し線、「＋ タスクを追加」ボタン）→ 追加・編集画面
- **やりかけ:** updated_at の実験（何も変えずに `save()` すると updated_at はどうなるか）※任意

## 🗺️ ロードマップ
| # | ステップ | 状態 | 重さ | 主に学ぶこと |
|---|---|---|---|---|
| 0 | 環境構築（PHP、Laravel Boost、SQLite） | ✅ | ― | WSL、artisan |
| 1 | テーブル作成 | ✅ | 小 | DB の基本、マイグレーション |
| 2 | モデルでデータ操作 | ✅ | 小 | PHP の基本、Eloquent、tinker |
| 3 | 一覧表示 | ✅ | **大** | ルーティング、コントローラー、Blade |
| 4 | 追加 | ✅ | 中 | フォーム、POST、CSRF |
| 5 | 入力チェック | ✅ | 小 | バリデーション |
| 6 | 編集 | ✅ | 中 | ルートパラメータ、PUT/PATCH |
| 7 | 完了 / 未完了の切り替え | ✅ | 小 | 更新の応用 |
| 8 | 削除 | ✅ | 小 | DELETE |
| 9 | 見た目を整える | 🔶 | 小〜中 | Tailwind CSS |

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
- `max` のメッセージはチェック対象ごとに分かれている。文字列（title）に使われるのは `'string'`（`'array'` と書くと英語のまま）
- `'attributes'` は対応表なので `'title' => 'タイトル'` のようにキー（入力欄の name）と値の両方を書く
- bash（WSL）でコマンドを改行するのは `\`（日本語キーボードでは「ろ」か「¥」キー）。`` ` `` は PowerShell 用
- `return` を書かないとブラウザには何も返らない。値を読むだけ（`$task->title;`）では何も起きない
- `find()` は見つからないと `null` を返す → 次の行で `Attempt to read property "title" on null`。`findOrFail()` なら 404
- 原因の行とエラーが出る行は別のことがある（`find()` の null は次の行の `$task->title` でエラー）
- Blade で値を入れるのは `{{ }}`（2 つ重ね）。`{ }` 1 つだとただの文字。ルートの `{id}` は穴あき部分の目印で、ビューでは `$task->id`
- `@foreach ($tasks as $task)` の中で使うのは 1 件の `$task`。`$tasks`（束）には id がない
- ビュー名 `tasks.edit` は `resources/views/tasks/edit.blade.php` のこと。`task.edit`（s なし）だと見つからない
- `@if` で囲むのは「条件によって出したいものだけ」。タイトルやリンクまで囲むと、未完了のタスクが消える
- `@if` の中では 1 は true、0 は false
- `$task->is_completed = !$task->is_completed;` のように、入れる先と入れる値に同じカラム。フォーム入力を使わないときは `$request` も `' '` もいらない
- `<form>` に `method="POST"` がないと GET で送られ、`@method('PATCH')` も効かない
- `<a>` は GET しか送れない。PATCH / PUT / DELETE はフォーム + `@method`
- `<form>` に `method` を書かないと GET（デフォルト）で送られる
- ビュー（blade.php）が必要なのは画面を見せるときだけ。`redirect` で終わる `store` / `update` / `toggle` / `destroy` には不要
- `confirm('...')` だけでは聞くだけ。`return confirm('...')` で送信を止められる
- Tailwind のクラスは必ず `class="..."` の中に書く（`<ul flex>` だと別々の属性と思われて無視される）
- `hover:bg-〇〇` は乗せたときだけ。ふだんの色（`bg-〇〇-500`）も別に必要
- `flex` は「並べたいもの」ではなく、それを包む **親** に付ける。横は `flex`、縦は `flex flex-col`
- `validate` はエラーを見つける役、`@error` は画面に出す役。フォームごとに `@error` が必要
- id=1 のタスクの due_date が `2026-9-30`（0 なし）で保存されている → フォーム作成時に正しい形式で保存する仕組みを入れる

## 🔧 環境メモ
- プロジェクトは WSL 側の `~/dev/todo-app`（2026-10-01 に Windows 側から引っ越し。表示が約 4 秒 → 0.3 秒に）
- 開き方: PowerShell で `wsl` → `cd ~/dev/todo-app` → `code .`（VS Code を WSL モードで開く）/ `claude`
- 旧フォルダ `C:\Users\merot\dev\laravel-app\task-manager` はバックアップとして残してある（使わない）
- `~/dev/task-manager` は 9 月に Sail で作った別のプロジェクト（触らない）
- 作業中のタブ: Claude Code / `php artisan serve` / `npm run dev`（Tailwind の CSS を作る係）
- PHP は `~/.config/herd-lite/bin`（php.new で導入）。DB は SQLite（`database/database.sqlite`）
- スマホでは OneDrive アプリの `task-manager/PROGRESS.md` で見られる（Claude の応答が終わるたびに自動で同期される）
- 言語は `.env` の `APP_LOCALE=ja`。日本語メッセージは `lang/ja/validation.php`（ないものは `lang/en` が使われる）
- VS Code の WSL モードでは、PHP などの拡張機能を「WSL: Ubuntu にインストール」する必要がある
- サーバーは別タブで起動（`wsl` → `cd ~/dev/todo-app` → `php artisan serve`）
- タイムゾーンは `Asia/Tokyo`（id=1 のタスクは変更前に UTC で保存されたもの）

---

# 📓 作業日誌

## 2026-10-13
### やったこと
- プロジェクトの目的・現在地を確認（MVP の機能はすべて完成、残りは見た目）
- ステップ9（見た目を整える）開始
  - `npm install` と `npm run dev` で Tailwind CSS（v4）を使える状態にした
  - `index.blade.php` を HTML の骨組み（`<!DOCTYPE html>`、`<head>`、`<body>`）で包み、`<head>` に `@vite(['resources/css/app.css'])` を書いた
  - レッスン10: CSS と Tailwind（クラス名は「何を-どれくらい」、数字 1 = 4px、色の濃さ 50〜950、`hover:`）
  - `<body class="p-6">`、`<h1 class="text-2xl font-bold mb-4">`、`<ul class="flex flex-col gap-2">`、`<li class="flex items-center gap-2">`、ボタンに色・余白・角丸・hover
  - つまずき: ボタンに `hover:` だけ付けた、`<ul flex flex-col gap-2>`（`class=` 忘れ）

### 次にやること
- 一覧の仕上げ（編集リンク、完了タスクに取り消し線、追加ボタン）→ 追加・編集画面にも骨組みと Tailwind

## 2026-10-11
### やったこと
- 復習クイズ: `<form>` に `method="POST"` がないと GET で送られ、`@method` は効かない
- ステップ8（削除）→ **ステップ8 完了**
  - `Route::delete('/tasks/{id}', ...)` と `destroy($id)`（findOrFail → `$task->delete()` → redirect）を 1 回で書けた
  - 一覧に削除ボタン（`method="POST"`、`@csrf`、`@method('DELETE')`）を付け、テスト用タスクで削除を確認
  - `$task = Task::findOrFail($id);` の意味を分解して整理した（URL の番号 → DB からタスクそのものを取り出す）
  - 迷ったこと: `delete.blade.php` が必要か（→ 画面を見せないので不要）、フォームを何から書くか（→ 切り替えボタンをコピーして 3 か所変える）

- 削除前の確認ダイアログ: `<form onsubmit="return confirm('本当に削除しますか？')">`
  - `confirm` は OK で true、キャンセルで false。`return` がないとキャンセルしても削除される
  - 属性（開始タグの中）は要素の設定、タグの間は中身。`onsubmit` はフォームの設定なので開始タグに書く
  - `" "` の中では `' '` を使う

### 次にやること
- ステップ9（Tailwind CSS で見た目を整える）

## 2026-10-09
### やったこと
- 日が空いたので復習: ルート → コントローラー → ビューの流れ、同じ URL を送り方（GET / POST）で区別、`@method('PUT')` が必要な理由
  - 同じ「送り方 + URL」を 2 回書くと、あとの方で上書きされる
- ステップ7（完了 / 未完了の切り替え）→ **ステップ7 完了**
  - `index.blade.php` で `@if ($task->is_completed)` を使い、完了したタスクに ✅ を表示
  - `Route::patch('/tasks/{id}/toggle', ...)` と `toggle($id)`（findOrFail → `!` で反対にする → save → redirect）
  - 一覧にフォーム（`method="POST"`、`@csrf`、`@method('PATCH')`、`action="/tasks/{{ $task->id }}/toggle"`）で切り替えボタンを付けた
  - PUT（全体を書き換え）と PATCH（一部だけ書き換え）の違い、`->` は「〜の」と読む
  - つまずき: `task.edit` の s 忘れ、`@if (is_completed)`、`@if` でタイトルまで囲んだ、`toggle` で `update` の形をまねて `$request->input('...')` と書いた、フォームを `<a>` の中に入れた、`method="POST"` 忘れ、`action` の `{id}` / `id`

### 次にやること
- ステップ8（削除）: `DELETE /tasks/{id}`、`destroy` メソッド、削除ボタン

## 2026-10-04
### やったこと
- 復習クイズ: `find()` が null を返す → エラーは次の行（`$task->title`）で出る、を確認
- `find` を `findOrFail` に変え、`/tasks/999/edit` が 404 になることを確認
- 編集フォーム: `edit` からビューに `$task` を渡し、`edit.blade.php` の `value="{{ $task->title }}"` でいまのタイトルを表示
- 更新: `Route::put('/tasks/{id}', ...)`、`@method('PUT')`、`action="/tasks/{{ $task->id }}"`、`update(Request $request, $id)`（findOrFail → validate → 書き換え → save → redirect）→ **ステップ6 完了**
  - HTML のフォームは GET / POST しか送れないので `@method('PUT')` を使う
  - つまずき: `valude` の打ち間違い、`/task/` の s 忘れ、`{{$task->{id}}}` や `{ $task->id }`（`{ }` の使い分け）、`update` で `$task` を取り出し忘れ、`edit.blade.php` に `@error` がなかった → すべて修正

- `{id}`（ルートの穴あき）/ `{{ }}`（Blade で値を出す）/ `{ }`（PHP の箱）の使い分けを復習クイズで確認
- 一覧の各タスクに `<a href="/tasks/{{ $task->id }}/edit">編集</a>` を付けた
  - つまずき: `{{ id }}` と書いた（`$task->` が必要）、`$tasks->id`（束ではなく 1 件の `$task`）、リンクを `<li>` の外に書いた → 修正

### 次にやること
- ステップ7（完了 / 未完了の切り替え）

## 2026-10-02
### やったこと
- 復習クイズ: `validate()` のキーは入力欄の `name`（`'title'`）→ 正解
- バリデーションのメッセージを日本語化 → **ステップ5 完了**
  - `php artisan lang:publish` で `lang/en/validation.php` を出し、メッセージ集の仕組み（`:attribute` `:max` の穴あき部分、fallback）を学んだ
  - `max` がチェック対象ごと（array / file / numeric / string）に分かれている理由を理解した
  - `lang/ja/validation.php` に `required` と `max.string` を自分で書き、`.env` を `APP_LOCALE=ja` に変更
  - `'attributes'` で `title` を「タイトル」と表示するようにした
  - つまずき: `max` のキーを `'array'` にした、`'attributes'` に値だけ書いた → 自分で修正
- VS Code の WSL モードでの拡張機能、bash での改行（`\`）を確認

- レッスン9: ルートパラメータ（ステップ6 開始）
  - `Route::get('/tasks/{id}/edit', ...)` と `edit($id)` を自分で書き、`Task::find($id)` → `return $task->title;` で URL の数字のタスクを表示できた
  - `/tasks/999/edit` で `Attempt to read property "title" on null` を確認 → `find()` は見つからないと null、`findOrFail()` なら 404 になることを学んだ
  - つまずき: ルートの書き方で手が止まった（既存のルートを 3 つの部分に分解して解決）、`edit` に `store` の `save()` / `redirect` をまねて書いた

### 次にやること
- `findOrFail` に書き換えて 404 を確認 → 編集フォーム（ビュー）→ `PUT /tasks/{id}` で更新

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
