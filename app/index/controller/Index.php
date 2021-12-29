<?php

namespace app\index\controller;

use think\Db;
use think\Request;

header('Access-Control-Allow-Origin:*');

class Index
{
  public function index(Request $request)
  {
    // 获取传递过来的数据
    $data = $request->param();

    if (
      $data['SOEID'] === '' ||
      $data['value_class'] === '' ||
      $data['value_work'] === '' ||
      $data['radio_today'] === ''
    ) {
      $result = array('code' => 402, 'msg' => '信息不完善');
      return json($result);
    }

    $data_list = [
      'SOEID' => $data['SOEID'],
      'value_class' => $data['value_class'],
      'value_work' => $data['value_work'],
      'radio_today' => $data['radio_today'],
      'opinion' => $data['opinion'],
      'release_time' => $data['release_time']
    ];
    Db::table('citi_form')->insert($data_list);

    $result = array('code' => 201, 'msg' => '添加成功');
    return json($result);
  }
}
