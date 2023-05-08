# openai-api-cli-php
PHPを使用し、CLIで受け付けた入力を元にOpenAI APIにリクエストを行い、得られた結果を表示するサンプルです。

## Requirements
- PHP: `>=7.4`

## 実行手順
1. リポジトリをクローン
2. `src`ディレクトリで`composer install`を実行し、パッケージをインストール
3. `.env.example`を`.env`というファイル名で同階層にコピー
4. `.env`にOpenAIで取得したAPIキーを設定
5. 必要に応じて`.env`で使用するOpenAIのモデルを指定
6. `index.php`を実行

## memo
検証用サンプルの為、以下は実装見送りました。
- [ ] OpenAI APIとのインタラクティブな会話
- [ ] 処理をクラス化し、ファイル分割
- [ ] Docker環境の用意
