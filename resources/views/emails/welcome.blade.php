<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
</head>

<body>
  <div style="padding:24px;">
    <div class="img" style="margin: 0  auto 32px auto; width: 270px;">
        <img src="https://fitcloset-clothing-items.s3.ap-northeast-1.amazonaws.com/assets/logo/FitCloset_logo.png" alt="FitCloset" style="width: 100%;">
    </div>
    <div
      style="padding:40px; background-color:#f9fafb; border-radius:8px; max-width:600px; margin:0 auto; margin-bottom:32px; color:black;">
      <h2 style="margin-bottom:16px; font-weight:bold;">FitCloset へようこそ、{{ $user->nickname }} さん</h2>
      <p style="margin-bottom:16px;">この度はご登録いただき、ありがとうございます。</p>
      <p style="margin-bottom:16px;">本サービスはポートフォリオデモアプリになります。</p>
      <p style="margin-bottom:16px;">あなたのクローゼットがより楽しく便利になりますように。</p>
      <a href="{{ route('home') }}"
        style="display:inline-block; padding:10px 16px; color:white; background-color:#4f46e5; text-decoration:none; border-radius:4px; font-size:14px;">
        マイページへ
      </a>
      <div style="margin-top:24px;">
        <p>今後ともどうぞよろしくお願いいたします。</p>
        <p>FitCloset 管理人</p>
      </div>
    </div>
    <small style="display:block; text-align:center; color: black;">©2025 FitCloset All Rights reserved.</small>
  </div>

</body>

</html>
