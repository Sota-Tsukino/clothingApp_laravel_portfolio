# FitCloset　衣類管理アプリ

Laravel × Tailwind CSS で構築された衣類管理・提案アプリです。
体格に応じた適切な衣類選びや、気温に応じた最適な衣類の提案を行います。

**URL**：https://fitcloset.net

製作期間：4カ月（516時間）

## デモアカウント

管理者用と一般ユーザー用アカウントを準備しておりますので、
ユーザー登録せずにお試しいただけます。

**管理者用アカウント**
　

- Email：admin@test.com

- Password：fitcloset_admin17


**ユーザーアカウント**

- Email：test1@test.com

- Password：testtest

※管理者用アカウントでログインした場合は登録ユーザーの管理権限が付与されます。

## 開発背景
私はこれまで衣類管理やサイズ選びが苦手で、購入時にサイズを間違えたり、その日の天候に合わない服を選んでしまうことが多くありました。
そこで、体格情報を登録し、購入前にサイズが合うかを判定できる「サイズチェッカー」と、天候に応じたコーディネートを提案する機能を備えた衣類管理アプリを開発しました。

## 機能
- ユーザー登録・ログイン（Laravel Breeze）
- パスワードリセット機能（Laravel Breeze）
- 体格情報の登録
- サイズチェッカー（体格情報に基づき、衣類サイズマッチング判定）
- 衣類アイテム登録・検索
- 天気情報の取得（天気API連携）
- 衣類アイテム提案メッセージ機能（天気API連携）
- コーデ登録・検索
- お問い合わせフォーム（Google Forms）
- ユーザー登録完了時のメール自動送信機能（Gmail SMTP）
  
## 工夫点
- **サイズ判定ロジックの工夫**
  
  ユーザーの体格情報をもとに上限・下限の許容値を設定し、「✅ちょうどいい」〜「✕大きく合わない」の4段階で判定可能にしました。

- **天気連動の衣類提案**
  
  気温帯ごとに最適な衣類カテゴリーを事前分類し、その日の気温に応じて衣類提案をするロジックを作成しました。例えば、気温が25℃以上なら、ポロシャツなどの夏向けの衣類を提案し、気温が5℃以下なら、ダウンコートなど冬物の衣類カテゴリーを提案します。

- **コーデ機能の柔軟性**
  
  登録済みアイテムから最大3つまで選び、自由にコーデを保存できるようにしました。

- **衣類の測定ガイド図の作図**
  
  各部位ごとの名称・測定部位が視覚的にわかるよう、衣類カテゴリーごとに測定ガイド図を１つ１つ作成をしました。


## 使用技術 Tech Stack　
| カテゴリ | 技術 | 
| --- | --- |
| フロントエンド | HTML / CSS / Tailwind CSS / JavaScript / Node.js / Vite | 
| バックエンド | PHP 8.3 / Laravel 10 / Composer |
| データベース | MySQL 8.0 |
| 認証 | Laravel Breeze |
| 環境構築 | MAMP 5.0.6 / Apache |
| 外部API | OpenStreetMap API / OpenWeatherMap API  |
| パッケージ・ライブラリ | Laravel Excel / Intervention Image / Micromodal.js / Choices.js / Alpine.js  |
| インフラ | Amazon Web Service (VPC, Route53, ELB, ACM, EC2, RDS, S3) |
| その他 | Gmail SMTP（メール送信）/ Google Forms（お問い合わせ）/ Figma（画面遷移図・ロゴ・アイコン作成）  |

### 技術選定理由と補足
#### フロントエンド
- **Tailwind CSS**
  
  UI設計・制作期間の短縮のため、クラスベースで即座にUI調整が可能で、デザインの統一性を持たせられると思い、採用しました。

#### バックエンド
- **Laravel**

  豊富なドキュメントや公式パッケージ群があり、認証・バリデーション・ルーティングなどの基本機能を効率的に実装できるため、採用しました。また、元々PHPを学習していたため、親和性も高いと思いました。


**外部API**
- **OpenStreetMap API & OpenWeatherMap API**
  
  無料枠が広く、商用利用にも対応していたため、採用しました。緯度・経度取得と天気情報取得を組み合わせて、ホーム画面でユーザー地域に基づく気象情報を表示できるようにしました。

**パッケージ・ライブラリ**
- **Intervention Image**
    
    ユーザーが登録する衣類画像のリサイズ・圧縮処理をサーバー側で自動化し、ストレージ容量と表示速度を最適化するため、採用しました。
    
- **Laravel Excel**
    
    データベースへの初期データ投入の効率化のため、CSVデータでインポートできるLaravel Excelを採用しました。
    
- **Choices.js**
    
    衣類アイテム登録時の色・季節など、タグ形式の複数選択UIを簡潔に実装できるため採用しました。

- **Alpine.js**
    
    Reactほど大規模な状態管理は不要で、軽量かつ学習コストが低く、衣類カテゴリごとのタブの切り替えなど、簡易的なUIインタラクションを実装できるため、採用しました。

**インフラ**
- **AWS**
  
  インフラ構築からデプロイまで一通り学習する目的と、MySQL対応の柔軟性・拡張性から採用しました。HerokuやRenderはコスト面・対応DBの制約で不採用としました。



## AWS構成図
<img width="600" alt="AWS構成図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/FitCloset_AWS%E3%82%A4%E3%83%B3%E3%83%95%E3%83%A9%E6%A7%8B%E6%88%90.jpg">

アプリ稼働に必要な最小限の構成にしております。ELBを採用しているのは、ACMによりSSL化（https）するためにあえて採用しました。

## 画面遷移図
<img width="995" alt="画面遷移図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E7%94%BB%E9%9D%A2%E9%81%B7%E7%A7%BB%E5%9B%B3.jpg">

## ER図
<img width="995" alt="ER図" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E8%A1%A3%E9%A1%9E%E7%AE%A1%E7%90%86%E3%82%A2%E3%83%97%E3%83%AA_ER%E5%9B%B3_initial_release.png">
テーブル構成は大きく分けて、「ユーザー情報」、「衣類アイテム情報」、「体格情報」の３つと、他はこれらに付随するマスターテーブル情報（市区町村・都道府県、素材など）に分類されます。

## デザイン（ロゴ・アイコン）
本ページに掲載しているロゴ・アイコンのデザインは、すべて学習目的で作成した自作のデザインです。　

※無断転載・使用はご遠慮ください。
<img width="995" alt="デザイン" src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/docs/%E3%83%AD%E3%82%B4%E3%83%BB%E3%82%A2%E3%82%A4%E3%82%B3%E3%83%B3%E3%83%87%E3%82%B6%E3%82%A4%E3%83%B3.png">

## 今後の課題について
- テストコードの実装
- Dockerを用いた環境構築
- コードのリファクタリングによる可読性・メンテナンス性の向上
- CI/CDを使用した自動デプロイ
- Github Flow / Git flowルールに基づく運用ルールの適用
