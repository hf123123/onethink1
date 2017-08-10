<?php
/**
 * Created by PhpStorm.
 * User: Shinelon
 * Date: 2017/8/10
 * Time: 14:59
 */

namespace Admin\Model;


use Think\Model;

class RepairModel extends Model
{
    protected $_validate = array(
        array('name', 'require', '姓名不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('tel', 'require', '电话不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('state', '1', self::MODEL_BOTH),
    );

}