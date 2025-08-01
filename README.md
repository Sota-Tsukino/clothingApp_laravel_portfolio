# FitCloset

Laravel × Tailwind CSS で構築された衣類管理・提案アプリです。
ユーザーの体型や気温に応じたコーディネート提案を行います。

## Features　機能
- ユーザー登録・ログイン（Laravel Breeze）
- 衣類アイテム登録・検索
- 衣類アイテム提案機能・メッセージ機能（天気API連携）
- コーデ登録・検索
- 体格情報の登録
- サイズチェッカー（体格情報に基づき、衣類サイズマッチング判定）
- お問い合わせフォーム（Google Forms）
- 登録完了時のメール自動送信機能（Gmail SMTP）
- パスワードリセット機能（Laravel Breeze）

## Tech Stack　使用技術
- PHP 8.3 / Laravel 10
- Tailwind CSS
- MySQL 8.0
- MAMP 5.0.6
- Apache
- Node.js
- Composer
- OpenWeatherMap API
- OpenStreetMap API
- Choice.js
- Alpine.js
- micromodal.js
- AWS
	- VPC
	- Route53
	- ELB
	- ACM
	- EC2
	- RDS
	- S3
- Google Form
- Figma（ロゴ・アイコン作成）

## AWS構成図
<img width="600" alt="AWS構成図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/FitCloset_AWS%E3%82%A4%E3%83%B3%E3%83%95%E3%83%A9%E6%A7%8B%E6%88%90.jpg">

## ER図
<img width="995" alt="AWS構成図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E8%A1%A3%E9%A1%9E%E7%AE%A1%E7%90%86%E3%82%A2%E3%83%97%E3%83%AA_ER%E5%9B%B3_initial_release.png">

## デザイン（ロゴ・アイコン）
<img width="995" alt="AWS構成図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E8%A1%A3%E9%A1%9E%E7%AE%A1%E7%90%86%E3%82%A2%E3%83%97%E3%83%AA_%E3%83%87%E3%82%B6%E3%82%A4%E3%83%B3.png">
