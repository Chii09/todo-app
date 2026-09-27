# 開発進捗

## 現在の状態
- Laravel 13 の初期状態（`laravel new` 直後）
- 進捗記録の仕組みを用意した（このファイル）
- 開発環境の準備が完了（PHP 8.5 / Composer / Laravel Boost）

## 全体 TODO
- [x] 進捗記録ファイルを作成
- [x] WSL に PHP / Composer をインストール
- [x] 初回コミット
- [x] Laravel Boost をインストール
- [x] DB 設定（SQLite）
- [ ] Todo アプリ MVP
  - [ ] Task モデル / マイグレーション / Factory
  - [ ] TaskController（CRUD + 完了切り替え）
  - [ ] Blade ビュー（一覧 / 作成 / 編集）
  - [ ] Feature テスト
- [ ] 認証（ユーザーごとの Todo）

---

## 2026-09-27
### やったこと
- プロジェクトの現状を確認した（独自機能は未実装、コミット0件）
- `docs/PROGRESS.md` を作成し、CLAUDE.md に進捗記録のルールを追記した
- php.new で PHP 8.5 / Composer 2.8 を WSL に導入した（`~/.config/herd-lite/bin`、PATH は `.bashrc` に追記済み）
- 初回コミットを作成した
- Laravel Boost 2.10 を導入した（guidelines / skills / MCP）
  - Boost が書き換えたのは AGENTS.md のみ → CLAUDE.md は `@AGENTS.md` で読み込む形に変更
  - `.mcp.json` が `wsl.exe` 経由になっていたので、php を直接呼ぶ形に修正

- DB を SQLite に切り替えた（`.env` の `DB_CONNECTION=sqlite`）
- 進め方を決めた: **コードは自分で書き、Claude は解説・ヒント・レビュー担当**（Claude が先に書いた Todo コードは破棄した）

### 次にやること
- Todo MVP（自分で実装）: まず Task モデル + マイグレーションから

### メモ
- 作るもの: Todo（タスク管理）アプリ
- このプロジェクトは Laravel の学習が目的。理解しながら進める
