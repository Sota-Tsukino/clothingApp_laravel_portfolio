<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{

    public function showServiceProviderTest() {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        $sample = app()->make('serviceProviderTest');
        dd($sample, $password, $encrypt->decrypt($password));
    }

    public function showServiceContainerTest()
    {
        // lifeCycleTestというサービスコンテナを登録
        app()->bind('lifeCycleTest', function () {
            return 'ライフサイクルテスト';
        });

        // サービスコンテナから取り出す
        $test = app()->make('lifeCycleTest');

        //サービスコンテナ無しパターン
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();


        //サービスコンテナapp()有りのパターン
        app()->bind('sample', Sample::class); //Messageクラスも自動でnewされて依存関係を解決
        $sample = app()->make('sample');
        $sample->run();

        dd($test, app());
    }
}

//今回テストなのでクラスごとにファイルは分けず、ここに全部記載
class Sample
{
    public $message;

    //DIという仕組みでこの引数にクラスを入れると自動的にインスタンス化してくれる
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    public function run()
    {
        $this->message->send();
    }
}

class Message
{
    public function send()
    {
        echo ('メッセージ表示');
    }
}
