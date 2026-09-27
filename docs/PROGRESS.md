# 開発進捗

## 現在の状態
- Laravel 13 の初期状態（`laravel new` 直後）
- 進捗記録の仕組みを用意した（このファイル）
- WSL に PHP / Composer が未インストール

## 全体 TODO
- [x] 進捗記録ファイルを作成
- [ ] WSL に PHP / Composer をインストール
- [ ] 初回コミット
- [ ] Laravel Boost をインストール
- [ ] DB 設定（SQLite 推奨）
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

### 次にやること
- WSL に PHP / Composer を入れる → 初回コミット → Boost → Todo MVP

### メモ
- 作るもの: Todo（タスク管理）アプリ
- `.env` は `DB_CONNECTION=mysql`。SQLite に切り替えるかは未決定
