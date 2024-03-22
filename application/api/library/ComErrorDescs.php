<?php

namespace app\api\library;

/**
 * Class ComErrorDescs [错误描述]
 * Auther Changzd
 * @package app\api\library
 */
class ComErrorDescs
{
    /** 调用成功 **/
    const EC_SUCCESS = 0;
    /*****************************************
     * API错误码区间  160000 - 168000
     *****************************************/
    /** API方法不存在 **/
    const EC_API_METHOD = 160000;
    /** API请求appid不在白名单中 **/
    const EC_NO_WHITE_APPID = 160001;
    /** 未知错误 **/
    const EC_UNKNOWN = 160002;
    /** 无权限 **/
    const EC_PERMISSION = 160003;
    /** 无效参数 **/
    const EC_INVALID_PARAM = 160004;
    /** 无效签名 **/
    const EC_INVALID_SIGN = 160005;
    /** 缺少参数 **/
    const EC_MISSING_PARAM = 160006;
    /** 无效HTTP方法 */
    const EC_INVALID_HTTPMETHOD = 160007;
    /** 用户未登录 **/
    const EC_NO_LOGIN_USER = 160008;
    /** 服务异常 **/
    const EC_SERVICE_FAILURE = 160009;
    /** 参数冲突 **/
    const EC_CONFLICT_PARAM = 160010;
    /** 参数为空 **/
    const EC_EMPTY_PARAM = 160011;
    /** 验证码生成失败 **/
    const EC_VCODE_GEN_FAILURE = 160012;
    /** 验证码验证失败 **/
    const EC_VCODE_VERIFY_FAILURE = 160013;
    /** 并行请求失败 **/
    const EC_MULTI_REQUEST_FAILURE = 160014;
    /** 远程图片采集失败 */
    const EC_REMOTE_IMAGE_FAILURE = 160015;
    /** 参数校验规则不存在 */
    const EC_PARAM_RULE_NOT_EXISTS = 160016;
    /** 只支持命令行模式 */
    const EC_CLI_ONLY = 160017;
    /** 请求签名时间超时 */
    const EC_TIMEOUT_SIGN_TIME = 160018;
    /** 未查询到数据 */
    const EC_NO_QUERY_RESULT = 160019;
    /** 非法操作 */
    const EC_WRONG_METHOD = 160020;


    /** 系统服务错误 100-200 */
    /** DB失败 **/
    const EC_DB_FAILURE = 100;
    /** REDIS失败 **/
    const EC_REDIS_FAILURE = 101;
    /** REDIS没有配置 **/
    const EC_REDIS_NOT_CONFIG = 102;
    /** 频繁访问 **/
    const EC_TOO_MANY_ACCESS = 103;

    /** HTTP错误 **/
    const EC_PAGE_NOT_FOUND = 404;
    /** 重定向url **/
    const EC_REDIRECT_URL   = -1;
    const APP_LOGIN_INVALID = 4000;
    /** 自定义提示语 **/
    const EC_CUSTOM_MESSAGE = 2000;

    /** Api **/
    const EC_GET_ACTION_WRONG = 10001;
    const EC_GET_DATA_LIMIT = 10002;

    /** 用户相关 **/
    const EC_USER_UNAPPLY = 20002;
    const EC_USER_ATTACH_UNAUTH = 20003;
    const VIP_REPEAT_GET = 200004;
    const EC_REPORT_LIMIT = 200005;

    /** 资料相关 **/
    const EC_DOC_UNEXISTS = 30001;
    const EC_DOC_NOTBUY = 30002;
    const EC_DOC_UNORIGINAL = 30003;


    /**
     * 错误码对应的错误信息数组
     *
     * @var array
     */
    public static $arrErrorDescs = array(
        self::EC_SUCCESS                   => '成功',
        self::EC_UNKNOWN                   => '未知错误，请重试',
        self::EC_API_METHOD                => 'API方法不存在',
        self::EC_NO_WHITE_APPID            => 'API请求appid不在白名单中',
        self::EC_PERMISSION                => '无权限',
        self::EC_INVALID_PARAM             => '无效参数 [%s]',
        self::EC_INVALID_SIGN              => '无效签名',
        self::EC_MISSING_PARAM             => '缺少参数 [%s] ',
        self::EC_INVALID_HTTPMETHOD        => '无效HTTP方法',
        self::EC_NO_LOGIN_USER             => '用户未登录',
        self::EC_SERVICE_FAILURE           => '服务器异常',
        self::EC_CONFLICT_PARAM            => '参数冲突',
        self::EC_EMPTY_PARAM               => '参数为空',
        self::EC_VCODE_GEN_FAILURE         => '验证码生成失败',
        self::EC_VCODE_VERIFY_FAILURE      => '验证码验证失败',
        self::EC_MULTI_REQUEST_FAILURE     => '并行请求失败',
        self::EC_REMOTE_IMAGE_FAILURE      => '远程图片采集失败',
        self::EC_PARAM_RULE_NOT_EXISTS     => '参数校验规则不存在',
        self::EC_CLI_ONLY                  => 'cli only',
        self::EC_DB_FAILURE                => '系统数据处理失败，请稍后重试',
        self::EC_REDIS_FAILURE             => 'REDIS失败',
        self::EC_REDIS_NOT_CONFIG          => 'REDIS没有配置',
        self::EC_TOO_MANY_ACCESS           => '频繁访问',
        self::EC_PAGE_NOT_FOUND            => 'HTTP错误',
        self::EC_REDIRECT_URL              => '重定向',
        self::EC_TIMEOUT_SIGN_TIME         => '签名时间超时请重试',
        self::EC_NO_QUERY_RESULT           => '未查询到相关结果',
        self::EC_WRONG_METHOD              => '非法操作',
        self::APP_LOGIN_INVALID            => '登录失效',
        self::EC_CUSTOM_MESSAGE            => '%s',
        /* Api */
        self::EC_GET_ACTION_WRONG          => 'action获取失败',
        self::EC_USER_UNAPPLY              => '用户未申请入驻',
        self::EC_USER_ATTACH_UNAUTH        => '无权限访问',
        /** 资料相关 **/
        self::EC_DOC_UNEXISTS              => '资料不存在',
        self::EC_DOC_NOTBUY                => '资料未购买',
        self::EC_DOC_UNORIGINAL            => '资料非原创，只允许橙币支付',
        self::EC_GET_DATA_LIMIT            => '访问次数受限制',
        self::EC_REPORT_LIMIT            => '生成报告达到上限',
    );

    /**
     * 根据错误码返回相应的错误信息
     *
     * @param int    $errcode
     * @param string $msg
     * @return string
     */
    public static function errmsg($errcode, $msg = '')
    {
        /*if (isset(static::$arrErrorDescs[$errcode])) {
            return static::$arrErrorDescs[$errcode];
        } else*/

        //记录日志的错误
        $records = [
            self::EC_UNKNOWN,
            self::EC_DB_FAILURE,
        ];

        //替换字符 errcode存在使用，不存在使用msg
        if (false !== strpos($errcode, ',')) {
            list($errcode, $repMsg) = explode(',', $errcode);
        } else {
            $repMsg = $msg;
        }
        //不明错误日志记录MSG
        if (isset(self::$arrErrorDescs[$errcode])) {
            if (in_array($errcode, $records)) {
                trace($errcode . ':' . $msg, 'error');
            }

            return sprintf(self::$arrErrorDescs[$errcode], $repMsg);
        } else {
            trace($errcode . ':' . $msg, 'error');
            return self::$arrErrorDescs[self::EC_UNKNOWN];
        }
    }
}
