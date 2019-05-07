<?php
/**
 * Created by PhpStorm.
 * @author: [1229046791@qq.com]
 * User: serena
 * Date: 2019/5/7
 * Time: 18:23
 */

namespace app\base\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test');//定义命令的名字
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('Hello World');//在命令行界面输出内容
    }
}