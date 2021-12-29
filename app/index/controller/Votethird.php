<?php

namespace app\index\controller;

use think\Db;
use think\Request;

header('Access-Control-Allow-Origin:*');

class Votethird
{
  // 登录
  public function onLogin(Request $request)
  {
    // 获取到前端传递来的参数
    $data = $request->param();

    // 当有一个字段传入为空值时，直接返回
    if ($data['SOEID'] === '') {
      $result = array('code' => 401, 'msg' => 'Incomplete information!');
      return json($result);
    }

    // 如果 SOEID 重复了则返回 301
    $citi_vote_user_third = Db::table('citi_vote_user_third')->select();
    foreach ($citi_vote_user_third as $key => $item) {
      if ($item['SOEID'] === $data['SOEID']) {
        $result = array('code' => 301, 'msg' => 'repeat');
        return json($result);
      }
    }

    $vote_user = [
      'SOEID' => $data['SOEID'],
      'time' => $data['time'],
    ];

    Db::table('citi_vote_user_third')->insert($vote_user);

    $result = array('code' => 201, 'msg' => 'Login succeeded');
    return json($result);
  }
  // 投票
  public function onVote(Request $request)
  {
    $data = $request->param();

    if (
      $data['SOEID'] === '' ||
      $data['choice_name_a'] === '' ||
      $data['time'] === ''
    ) {
      // 不完全的信息
      $result = array('code' => 402, 'msg' => 'Incomplete information!');
      return json($result);
    }

    $choice_name = ['choice_name_a'];

    foreach ($choice_name as $key => $item) {
      $vote_list = [
        'SOEID' => $data['SOEID'],
        'choice_name' => $data[$item],
        'time' => $data['time'],
      ];
      Db::table('citi_vote_list_third')->insert($vote_list);
    }

    $result = array('code' => 201, 'msg' => 'ok');
    return json($result);
  }
  // 获取投票结果
  public function getVoteRes(Request $request)
  {
    $users_name = [
      'Alisa Wang',
      'Angela Long',
      'Angela Kong',
      'Annie Tang',
      'Anqi Hu',
      'Ariel Chen',
      'Audrey Guo',
      'Bill Wang',
      'Billy Sun',
      'Brenda Zhao',
      'Carmen Jiang',
      'Catherine Kong',
      'Cecilia Zhang',
      'Chloe Jin',
      'Chris Xu',
      'Daniel Zhou',
      'Do_Young Jeong',
      'Elaine Shen',
      'Emily Hua',
      'Erik Emilsson',
      'Gina Tang',
      'Irwin Wen',
      'Jeff Zheng',
      'Jeff Chen',
      'Jenny Yan',
      'Jiahui Hou',
      'Joanne Goh',
      'Johnson Cui',
      'Jolin Shi',
      'Judy Liu',
      'Kelly He',
      'Lancy Wang',
      'Lei Wang',
      'Lilian Xu',
      'Lina Tao',
      'Lu Shi',
      'Luna Chen',
      'Michael Chung',
      'Michael Zhu',
      'Nichole Kuang',
      'Oskar Gu',
      'Rachel Han',
      'Roderick Peek',
      'Shawn Shao',
      'Sylvia Wang',
      'Yufei Mao',
      'Zoe Zhang',
    ];

    $result = array();
    foreach ($users_name as $key => $item) {
      $res = Db::table('citi_vote_list_third')->where('choice_name', $item)->select();
      $arr_length = sizeof($res);

      // 投票结果
      $userList = array(
        'name' => $item,
        'num' => $arr_length,
      );
      array_push($result, $userList);
    }

    $res = array(
      'code' => 201,
      'msg' => 'ok',
      'data' => array_reverse($result)
    );
    return json($result);
  }
}
