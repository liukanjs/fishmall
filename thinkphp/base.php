<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

define('THINK_VERSION', '5.0.0 RC4');
define('THINK_START_TIME', number_format(microtime(true), 8, '.', ''));
define('THINK_START_MEM', memory_get_usage());
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('THINK_PATH') or define('THINK_PATH', __DIR__ . DS);
define('LIB_PATH', THINK_PATH . 'library' . DS);
define('CORE_PATH', LIB_PATH . 'think' . DS);
define('TRAIT_PATH', LIB_PATH . 'traits' . DS);
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS);
defined('ROOT_PATH') or define('ROOT_PATH', dirname(APP_PATH) . DS);
defined('EXTEND_PATH') or define('EXTEND_PATH', ROOT_PATH . 'extend' . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS);
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'log' . DS);
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
defined('TEMP_PATH') or define('TEMP_PATH', RUNTIME_PATH . 'temp' . DS);
defined('CONF_PATH') or define('CONF_PATH', APP_PATH); // 配置文件目录
defined('CONF_EXT') or define('CONF_EXT', EXT); // 配置文件后缀
defined('ENV_PREFIX') or define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? true : false);
defined('TOOLS_PATH') or define('TOOLS_PATH', LIB_PATH . 'tools' . DS);
defined('LOGIC_LAYER') or define('LOGIC_LAYER', 'logic');
define('CHARSET', 'utf-8');
define('InCnbbx', true);
define('TIMESTAMP', time());
defined('InCnbbx') or exit('Access Invalid!');

// 载入Loader类
require CORE_PATH . 'Loader.php';

// 加载环境变量配置文件
if (is_file(ROOT_PATH . 'env' . EXT)) {
    $env = include ROOT_PATH . 'env' . EXT;
    foreach ($env as $key => $val) {
        $name = ENV_PREFIX . strtoupper($key);
        if (is_bool($val)) {
            $val = $val ? 1 : 0;
        } elseif (!is_scalar($val)) {
            continue;
        }
        putenv("$name=$val");
    }
}

// 注册自动加载
\think\Loader::register();

// 注册错误和异常处理机制
\think\Error::register();

// 加载模式配置文件
\think\Config::set(include THINK_PATH . 'convention' . EXT);
