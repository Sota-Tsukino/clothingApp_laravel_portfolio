# FitCloset　衣類管理アプリ
本アプリはポートフォリオアプリです。

Laravel × Tailwind CSS で構築された衣類管理・提案アプリです。
体格に応じた適切な衣類選びや、気温に応じた最適な衣類の提案を行います。

## Features　機能
- ユーザー登録・ログイン（Laravel Breeze）
- パスワードリセット機能（Laravel Breeze）
- 体格情報の登録
- サイズチェッカー（体格情報に基づき、衣類サイズマッチング判定）
- 衣類アイテム登録・検索
- 天気情報の取得（天気API連携）
- 衣類アイテム提案メッセージ機能（天気API連携）
- コーデ登録・検索
- お問い合わせフォーム（Google Forms）
- 登録完了時のメール自動送信機能（Gmail SMTP）

## Tech Stack　使用技術

### 言語・フレームワーク
- PHP 8.3 / Laravel 10
- Tailwind CSS
- Alpine.js
- Node.js / Vite
- Composer

### パッケージ・ライブラリ
- Laravel Breeze
- Laravel Excel
- Intervention Image
- Micromodal.js
- Choice.js

### データベース・API
- MySQL 8.0
- OpenWeatherMap API
- OpenStreetMap API

### インフラ・開発環境
- MAMP 5.0.6（ローカル開発）
- Apache
- AWS（VPC, Route53, ELB, ACM, EC2, RDS, S3）

### その他
- Gmail SMTP（メール送信）
- Google Forms（お問い合わせ）
- Figma（画面遷移図・ロゴ・アイコン作成）

## AWS構成図
<img width="600" alt="AWS構成図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/FitCloset_AWS%E3%82%A4%E3%83%B3%E3%83%95%E3%83%A9%E6%A7%8B%E6%88%90.jpg">

## 画面遷移図
<img width="995" alt="画面遷移図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E7%94%BB%E9%9D%A2%E9%81%B7%E7%A7%BB%E5%9B%B3.jpg">

## ER図
<img width="995" alt="ER図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E8%A1%A3%E9%A1%9E%E7%AE%A1%E7%90%86%E3%82%A2%E3%83%97%E3%83%AA_ER%E5%9B%B3_initial_release.png">

## デザイン（ロゴ・アイコン）
※本ページに掲載しているロゴ・アイコンのデザインは、すべて学習目的で作成した自作のデザインです。無断転載・使用はご遠慮ください。
<img width="995" alt="デザイン" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E3%83%AD%E3%82%B4%E3%83%BB%E3%82%A2%E3%82%A4%E3%82%B3%E3%83%B3%E3%83%87%E3%82%B6%E3%82%A4%E3%83%B3.png">
