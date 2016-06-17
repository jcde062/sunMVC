<?php
// +----------------------------------------------------------------------
// | ylsunyuan
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://www.ylsunyuan.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: sun <QQ 276 572 447>
// +----------------------------------------------------------------------
// | 路由器  
// | 1、路由参数解析  index.php?r=/Admin/Login/checkLogin/cid/4/id/1.html
// | 2、参数过滤并且防止SQL注入
// | 3、实例化对应控制器和方法
// +----------------------------------------------------------------------


class router{

	private static $r      = "";	//当前URL
	private static $m      = "";	//当前URl模块
	private static $c      = "";	//当前URl控制器
	private static $a      = "";	//当前动作方法

    public static $urlParamers   = array(); // 当前路由参数（所有,包含模块名、控制器名、方法名）数组
    public static $paramers      = array(); // 当前路由参数数组(只有参数，没有mca)

    private static $r_config     = array(); // 获取路由相关配置



    /**
     * 路由器初始化
     * @param void
     * @return null
     */
    public static function start(){
        // 判断是否空参数操作
        self::r_empty();

        // 获取路由
        self::getUrlParamers();

        echo "<pre>";
        var_dump(self::$paramers);
        echo "</pre>";

        echo self::$r."|".self::$m."|".self::$c."|".self::$a;

        self::startAction();

    }


    /**
     * 路由器获取传参
     * @param void
     * @return null
     */
    private static function getUrlParamers(){

        // 参数数组初始化
        $paramers = array();
        // 截取路由参数
        $r_paramers = substr(self::$r,1,-5);
        // 把当前路由参数保存到数组中，供外部公开使用
        self::$urlParamers = explode('/', $r_paramers); 
        // 获取数组长度
        $paramersLength = sizeof(self::$urlParamers);


        if($paramersLength>=3)
        {
            self::$m = self::$urlParamers[0];  // 当前模块
            self::$c = self::$urlParamers[1];  // 当前控制器
            self::$a = self::$urlParamers[2];  // 当前动作函数
        }else{
            self::r_error(0); // MCA参数错误
        }


        if($paramersLength>3 && ($paramersLength-3)%2==0) //  
        {
            
            for($i=3;$i<$paramersLength;$i=$i+2){
                // 参数转化 k=>v  关联数组
                $paramers[self::$urlParamers[$i]] = self::$urlParamers[$i+1];
            }
            // 保存当前参数
            self::$paramers = $paramers;
        }else{
            self::r_error(1); // 字参数错误
        }

    }


     /**
     * 路由器参数错误校验
     * @param $i : 1-n
     * @return null
     */
     private static function r_error($i){
        if($i == 0){ // mca参数缺漏 
            die("<h1>:( router MCA loss !</h1>");
        }
         
        if($i == 1){ // 普通参数缺漏 
            die("<h1>:( router paramers loss !</h1>");
        }
        
        if($i == 2){ // 判断 M C A 以及 Class 是否存在
        }        

     }



     /**
     * 路由器 空操作/默认模块解析
     * @param void
     * @return null
     */
     private static function r_empty(){
        // 获取当前路由Url
        if($_GET['r'] == "" or $_GET['r'] == null){
            self::$r = '/Demo/demoCtrl/demoFunction.html';
            return true;
        }else{
            self::$r = @$_GET['r'];
            return false;
        }

     }



    /**
     * 获取路由器配置
     * @param void
     * @return null
     */
    private static function getRouterConfig(){
        // 获取路由配置
        include '../../Public/Config/config.php';
    }



    /**
     * 路由器操作总控制器
     * @param void
     * @return null
     */
    private static function startAction(){
        echo "<h1>:) mvcstart...</h1>";
    }


}