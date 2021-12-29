<?php

namespace app\index\controller;

use think\Db;
use think\Request;

header('Access-Control-Allow-Origin:*');

class Vote
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

    $vote_user = [
      'SOEID' => $data['SOEID'],
      'time' => $data['time'],
    ];

    Db::table('citi_vote_user')->insert($vote_user);

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
      $data['choice_name_b'] === '' ||
      $data['choice_name_c'] === '' ||
      $data['time'] === ''
    ) {
      // 不完全的信息
      $result = array('code' => 402, 'msg' => 'Incomplete information!');
      return json($result);
    }

    $choice_name = ['choice_name_a', 'choice_name_b', 'choice_name_c'];

    foreach ($choice_name as $key => $item) {
      $vote_list = [
        'SOEID' => $data['SOEID'],
        'choice_name' => $data[$item],
        'time' => $data['time'],
      ];
      Db::table('citi_vote_list')->insert($vote_list);
    }

    $result = array('code' => 201, 'msg' => 'ok');
    return json($result);
  }
  // 获取投票结果
  public function getVoteRes(Request $request)
  {
    $users_name = [
      'Amber Wang',
      'Amy Miao',
      'Angel Guo',
      'Annie Yang',
      'Apple Hu',
      'Belle Xia',
      'Brown Liu',
      'Candy Deng',
      'Carrie Fan',
      'Catherine Xia',
      'Cathy Zheng',
      'Charlene Fan',
      'Charles Liu',
      'Chris Wen',
      'Christine Xie',
      'Chulun Wang',
      'Cindy Zuo',
      'Crystal Liu',
      'Da Luo',
      'David Jiang',
      'Duoxin Chen',
      'Echo Ou',
      'Elaine Shen',
      'Ellen Wang',
      'Evelyn Zhu',
      'Fiona Ou',
      'Hao Wang',
      'Hex Zhao',
      'Ivy Zhu',
      'Jacky Zhang',
      'Jane Ge',
      'Jesse Song',
      'Jia Pan',
      'John Hu',
      'Joseph Zhao',
      'Joy Qiao',
      'Kai Wang',
      'Katherine Chen',
      'Keira Zhang',
      'Kelly Yang',
      'Laura Zhang',
      'Linlin Sun',
      'Lisa Zhou',
      'Melody Xu',
      'Mengmeng Jia',
      'Michelle Xia',
      'Michelle Yan',
      'Naitong Ji',
      'Olivia Ma',
      'Ralph Chen',
      'Rickie Ma',
      'Roger Tao',
      'Ruby Wu',
      'Rui Lou',
      'Sara Jiang',
      'Shirley Shao',
      'Simone Huang',
      'Sophia Ma',
      'Sophie Xu',
      'Sunny Chen',
      'Sylvia Qiu',
      'Tian Dai',
      'Tina Song',
      'Tracy Zhou',
      'Ula Sun',
      'Victor Pan',
      'Violet Zhao',
      'Vivian Zhang',
      'Xiaohan Yang',
      'Xiaorong Yang',
      'Yang Cao',
      'Yaning Zhang',
      'Yizhou Peng',
      'Yvonne Zhu',
    ];

    $result = array();
    foreach ($users_name as $key => $item) {
      $res = Db::table('citi_vote_list')->where('choice_name', $item)->select();
      $arr_length = sizeof($res);
      array_push($result, $arr_length);
    }

    $res = array(
      'code' => 201,
      'msg' => 'ok',
      'data' => array_reverse($result)
    );
    return json($result);
  }
}
