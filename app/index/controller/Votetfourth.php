<?php

namespace app\index\controller;

use think\Db;
use think\Request;

header('Access-Control-Allow-Origin:*');

class Votetfourth
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
    $citi_vote_user_fourth = Db::table('citi_vote_user_fourth')->select();
    foreach ($citi_vote_user_fourth as $key => $item) {
      if ($item['SOEID'] === $data['SOEID']) {
        $result = array('code' => 301, 'msg' => 'repeat');
        return json($result);
      }
    }

    $vote_user = [
      'SOEID' => $data['SOEID'],
      'time' => $data['time'],
    ];

    Db::table('citi_vote_user_fourth')->insert($vote_user);

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
      Db::table('citi_vote_list_fourth')->insert($vote_list);
    }

    $result = array('code' => 201, 'msg' => 'ok');
    return json($result);
  }
  // 获取投票结果
  public function getVoteRes(Request $request)
  {
    $users_name = [
      'lsa_Wang_GSG',
      'Angel Guo_TTLC',
      'Angel_Ding_GSG',
      'Annie_Tang_GSG',
      'Ariel_Chen_GSG',
      'Audrey_Guo_GSG',
      'Belle_Xia_TTLC',
      'Bill_Wang_GSG',
      'Cathy_Zheng_TTLC',
      'Chloe_Jin_GSG',
      'Daniel_Zhou_Pool RA',
      'Emma_Lin_GSG',
      'Hao_Wang_TTLC',
      'Helen_Zhang_GSG',
      'Irwin_Weng_Pool RA',
      'Jane_Ge_TTLC',
      'Jerri_Xu_GSG',
      'Jesse_Song_TTLC',
      'Jessica_He_GSG',
      'Johnson_Cui_GSG',
      'Jolin_Shi_GSG',
      'Kelly_He_GSG',
      'Kitty_Chen_GSG',
      'Lei_Wang_GSG',
      'Lina_Tao_GSG',
      'Lin_Qi_GSG',
      'Lizi_Chen_GSG',
      'Luna_Chen_GSG',
      'Manni_Xu_GSG',
      'Mary_Ma_GSG',
      'Naitong_Ji_TTLC',
      'Silver_Xie_GSG',
      'Sunny_Chen_TTLC',
      'Tina_Song_TTLC',
      'Ting_Ou_TTLC',
      'Vera_Zeng_GSG',
      'Wendy_Wang_GSG',
      'Xinxin_Wang_Pool RA',
      'Yaning_Zhang_TTLC',
      'Yuting_Zhu_TTLC',
    ];

    $result = array();
    foreach ($users_name as $key => $item) {
      $res = Db::table('citi_vote_list_fourth')->where('choice_name', $item)->select();
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
