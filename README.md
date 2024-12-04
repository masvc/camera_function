# カメラ機能 Web アプリケーション

## 概要

このアプリケーションは、Web ブラウザのカメラ機能を使用して写真を撮影し、サーバーに保存・管理できるシンプルな Web アプリケーションです。

## 主な機能

- Web カメラを使用した写真撮影
- プレビュー表示と撮り直し機能
- 撮影した写真の自動保存
- 保存済み写真の一覧表示（撮影日時付き）

## 動作環境

- PHP 7.0 以上
- Web サーバー（Apache/Nginx）
- カメラ API 対応のモダンブラウザ
- 書き込み権限のあるアップロードディレクトリ

## ファイル構成

```
camera_function/
├── css/
│ ├── camera.css # カメラ画面のスタイル
│ └── style.css # 共通・一覧画面のスタイル
├── uploads/ # 画像保存ディレクトリ
├── index.php # カメラ撮影画面
├── main.php # 写真一覧画面
└── save_image.php # 画像保存処理
```

## 使用方法

1. `index.php`にアクセスしてカメラを起動
2. カメラのアクセス許可を承認
3. 「撮影」ボタンで写真を撮影
4. 必要に応じて「撮り直し」
5. 「写真一覧を見る」で保存された写真を確認可能

## 注意事項

- ブラウザのカメラへのアクセス許可が必要です
- `uploads`ディレクトリに書き込み権限が必要です
- 画像は自動的に JPEG 形式で保存されます

## セキュリティ

- アップロードされる画像形式は JPEG/PNG のみに制限
- Base64 デコードによる画像データの検証を実施
