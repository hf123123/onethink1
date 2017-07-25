<?php

use yii\db\Migration;

class m170725_020806_alter_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user','last_login_time','integer');
        $this->addColumn('user','last_login_ip','integer');
    }

    public function safeDown()
    {
        $this->dropColumn('user','last_login_time');
        $this->dropColumn('user','last_login_ip');
        //echo "m170725_020806_alter_user_table cannot be reverted.\n";

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170725_020806_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
