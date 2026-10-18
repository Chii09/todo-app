# Todo アプリ

<p>
  <img src="https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-8-646CFF?logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white" alt="SQLite">
</p>

タスクの追加・一覧・編集・完了の切り替え・削除ができる Todo アプリです。
PHP・Laravel を初めて学ぶにあたり、Web アプリが動く仕組み（ルーティング → コントローラー → データベース → 画面）を理解するために、個人で一から開発しました。

## 目次

- [機能](#機能)
- [使用技術](#使用技術)
- [開発の目的と期間](#開発の目的と期間)
- [工夫した点](#工夫した点)
- [苦労した点と解決方法](#苦労した点と解決方法)
- [学習の進め方](#学習の進め方)
- [ルーティング一覧](#ルーティング一覧)
- [テーブル設計](#テーブル設計)
- [ディレクトリ構成](#ディレクトリ構成)
- [環境構築](#環境構築)
- [トラブルシューティング](#トラブルシューティング)
- [今後の展望](#今後の展望)

## 機能

| 機能 | 内容 |
| --- | --- |
| 一覧表示 | 登録したタスクを一覧で表示。完了したタスクには ✅ と取り消し線を表示 |
| 追加 | フォームからタスクを追加。タイトルが空・255 文字超のときは日本語のエラーメッセージを表示 |
| 編集 | 現在のタイトルが入った状態のフォームで書き換え |
| 完了 / 未完了の切り替え | ボタン 1 つで状態を切り替え |
| 削除 | 確認ダイアログで「OK」を押したときだけ削除 |

## 使用技術

| 分類 | 技術 |
| --- | --- |
| 言語 | PHP 8.5 |
| フレームワーク | Laravel 13 |
| テンプレート | Blade（Blade コンポーネントによるレイアウト） |
| スタイリング | Tailwind CSS v4 |
| ビルドツール | Vite 8 |
| データベース | SQLite |
| 開発環境 | WSL2（Ubuntu）、VS Code |
| バージョン管理 | Git / GitHub |

## 開発の目的と期間

- **目的:** PHP・Laravel は未経験だったため、CRUD（作成・読み取り・更新・削除）を一通り自分の手で実装し、Web アプリの基本的な仕組みを理解すること
- **期間:** 2026 年 9 月 27 日 〜 10 月 14 日（約 3 週間）
- **体制:** 個人開発

## 工夫した点

- **入力チェックとエラーメッセージの日本語化**
  追加・編集の両方でタイトルを検証し、`lang/ja/validation.php` を作成してエラーメッセージを日本語で表示しています。項目名も `attributes` で「タイトル」と表示されるようにしました。
- **存在しないタスクへのアクセスを 404 に**
  `find()` は見つからないと `null` を返し、次の行でエラーになることを実際に確かめたうえで、`findOrFail()` に変更しました。
- **HTTP メソッドの使い分け**
  HTML のフォームは GET と POST しか送れないため、`@method` を使って更新（PUT）・状態の切り替え（PATCH）・削除（DELETE）を使い分けています。
- **誤操作の防止**
  削除ボタンに確認ダイアログを付け、キャンセルしたときは送信されないようにしました。
- **レイアウトの共通化**
  HTML の骨組みと CSS の読み込みを Blade コンポーネント（`<x-layout>`）にまとめ、全画面の見た目をそろえています。

## 苦労した点と解決方法

### ページの表示が約 4 秒かかる

開発の途中で、ページを開くたびに約 4 秒かかるようになりました。原因を調べたところ、WSL（Ubuntu）から Windows 側のフォルダにあるファイルを読み込む処理が遅いことがわかりました。
プロジェクトを WSL 側のフォルダ（`~/dev/todo-app`）に移したことで、表示が **約 0.3 秒** に改善しました。

### ルートの `{id}` と Blade の `{{ $task->id }}` の使い分け

URL の中の番号を扱う場面で、ルート定義の `{id}`（値が入る場所の目印）と、Blade で値を表示する `{{ $task->id }}` を混同しました。
「どのファイルに書いているか」「値を取り出すのか、目印なのか」で整理し、ページのソースを表示して、実際に出力される URL を確かめながら修正しました。

## 学習の進め方

- AI を **解説・コードレビュー役** として使い、アプリのコードはすべて自分で書きました。
- つまずいた点は毎回 [`docs/PROGRESS.md`](docs/PROGRESS.md) の「つまずきメモ」に記録し、次の作業の始めに復習クイズで確認しています。

## ルーティング一覧

| メソッド | URL | コントローラー | 内容 |
| --- | --- | --- | --- |
| GET | `/tasks` | `TaskController@index` | 一覧表示 |
| GET | `/tasks/create` | `TaskController@create` | 追加フォーム |
| POST | `/tasks` | `TaskController@store` | 追加 |
| GET | `/tasks/{id}/edit` | `TaskController@edit` | 編集フォーム |
| PUT | `/tasks/{id}` | `TaskController@update` | 更新 |
| PATCH | `/tasks/{id}/toggle` | `TaskController@toggle` | 完了 / 未完了の切り替え |
| DELETE | `/tasks/{id}` | `TaskController@destroy` | 削除 |

## テーブル設計

**tasks**

| カラム | 型 | 説明 |
| --- | --- | --- |
| id | integer | 主キー |
| title | string | タイトル（必須） |
| description | text | 説明（空でも可） |
| due_date | date | 期限（空でも可） |
| is_completed | boolean | 完了しているか（初期値: false） |
| created_at / updated_at | timestamp | 作成日時 / 更新日時 |

## ディレクトリ構成

主に自分で作成・編集したファイルです。

```
.
├── app/
│   ├── Http/Controllers/
│   │   └── TaskController.php        # 一覧・追加・編集・更新・切り替え・削除
│   └── Models/
│       └── Task.php
├── database/
│   └── migrations/
│       └── 2026_09_28_025903_create_tasks_table.php
├── docs/
│   └── PROGRESS.md                   # 進捗と学習の記録
├── lang/
│   └── ja/
│       └── validation.php            # 日本語のエラーメッセージ
├── resources/
│   └── views/
│       ├── components/
│       │   └── layout.blade.php      # 共通レイアウト
│       └── tasks/
│           ├── index.blade.php       # 一覧
│           ├── create.blade.php      # 追加フォーム
│           └── edit.blade.php        # 編集フォーム
└── routes/
    └── web.php
```

## 環境構築

### 必要なもの

- PHP 8.3 以上
- Composer
- Node.js / npm

### 手順

```bash
# 1. リポジトリを取得
git clone <このリポジトリの URL>
cd todo-app

# 2. PHP と JavaScript のパッケージをインストール
composer install
npm install

# 3. 環境設定ファイルを作成し、アプリケーションキーを生成
cp .env.example .env
php artisan key:generate

# 4. データベース（SQLite）を作成してテーブルを作る
touch database/database.sqlite
php artisan migrate
```

エラーメッセージを日本語で表示するには、`.env` の `APP_LOCALE` を `ja` にしてください。

```
APP_LOCALE=ja
```

### 起動

ターミナルを 2 つ開き、それぞれで実行します。

```bash
# サーバー
php artisan serve

# CSS のビルド（Tailwind CSS）
npm run dev
```

ブラウザで http://127.0.0.1:8000/tasks を開きます。

## トラブルシューティング

| 症状 | 対処 |
| --- | --- |
| `Unable to locate file in Vite manifest` | `npm run dev` が起動しているか確認する（または `npm run build` を実行する） |
| 見た目（CSS）が反映されない | `npm run dev` を起動し直し、ブラウザで Ctrl + F5 を押す |
| `database.sqlite does not exist` | `touch database/database.sqlite` を実行してから `php artisan migrate` |
| エラーメッセージが英語のまま | `.env` の `APP_LOCALE` を `ja` にして、`php artisan serve` を起動し直す |
| WSL で表示がとても遅い | プロジェクトを Windows 側（`/mnt/c/...`）ではなく、WSL 側のフォルダに置く |

## 今後の展望

- 名前付きルート（`route()`）を使った URL の生成
- PHPUnit による機能テスト
- Factory / Seeder によるテストデータの作成
- ログイン機能を追加し、ユーザーごとにタスクを管理
