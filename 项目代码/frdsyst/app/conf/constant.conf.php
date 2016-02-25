<?php
/**
 * --------------------------------------------------------------------------- 
 * 常量定义 定义规则: 
 * <p> 
 * 1. 所有常量的定义必须使用 /** 类型的方法级 注释，便于常量使用时清楚其对应信息！ 
 * 2. 常量必须全大写，用 _ 作为分割符 
 * 3. 尽量常量的开头为可快速定位的一些字符，如对应session中字段定义，例：SESSION_USER, 共通：COMM_X, 球队： TEAM_X 
 * </p>
 *  --------------------------------------------------------------------------- 
 *  <strong>copyright</strong>： ©版权所有 成都国腾电子技术股份有限公司<br> 
 *  ---------------------------------------------------------------------------- 
 *  @author:hewei @time:2013-8-28 下午2:22:46 
 *  ---------------------------------------------------------------------------
 */

/**
 * ********************************* 接口返回状态 *************************************
 */
define ('RESP_SUCCESS', 200); // 成功返回 接口处理正常，正常返回数据
define ('RESP_ERROR', 500); // 通用异常 接口处理异常，返回信息异常
define ('RESP_FORBIDEN', 403); // 禁止访问

/**
 * ***************************** 微信平台相关配置 ******************************
 */

define ('WX_EXPIRES_IN_BEFORE', 300); // 微信access_token,jsapi_ticket过期提前缓存时间量

define ('WX_EVENT_SUBSCRIBE', 'subscribe'); // 微信事件：订阅
define ('WX_EVENT_UNSUBSCRIBE', 'unsubscribe'); // 微信事件：取消订阅
define ('WX_EVENT_SCAN', 'SCAN'); // 微信事件：二维码扫描(用户已关注时的事件推送)
define ('WX_EVENT_LOCATION', 'LOCATION'); // 微信事件：上报地理位置事件
define ('WX_EVENT_CLICK', 'CLICK'); // 微信事件：点击菜单拉取消息时的事件推送
define ('WX_EVENT_VIEW', 'VIEW'); // 微信事件：点击菜单跳转链接时的事件推送

define ('WX_MSG_TYPE_TEXT', 'text'); // 微信消息类型：文本消息
define ('WX_MSG_TYPE_IMAGE', 'image'); // 微信消息类型：图片消息
define ('WX_MSG_TYPE_VOICE', 'voice'); // 微信消息类型：语音消息
define ('WX_MSG_TYPE_VIDEO', 'video'); // 微信消息类型：视频消息
define ('WX_MSG_TYPE_LOCATION', 'location'); // 微信消息类型：地理位置消息
define ('WX_MSG_TYPE_LINK', 'link'); // 微信消息类型：链接消息

define ('WX_OAUTH2_STATE_000', 'WXOAUTH2STATE000'); // 微信静默登录state参数:强制登录或者自动登录

/**
 * *********各种默认收益数值 ***************
 */
/**
 * 徒弟文章访问收益*
 */
define ('CHILD_FOR_PARENT_PRICE', 0.01); // 徒弟文章访问收益
/**
 * 注册收益*
 */
define ('REGIST_PRICE', 1); // 注册收益
/**
 * 邀请徒弟收益*
 */
define ('CHILD_REGIST_PRICE', 0.5); // 邀请徒弟收益
/**
 * 默认文章访问收益*
 */
define ('DEFAULT_ARTICLE_PRICE', 0.05); // 默认文章访问收益

/**
 * ***************************** 缓存KEY ******************************
 */
define ('CACHE_KEY_WX_ACCESS_TOKEN', 'CACHE_KEY_WX_ACCESS_TOKEN'); // 缓存：微信access_token
define ('CACHE_KEY_WX_JSAPI_TICKET', 'CACHE_KEY_WX_JSAPI_TICKET'); // 缓存：微信jsapi_ticket

/**
 * ***************************** Session KEY ******************************
 */
define ('SESS_KEY_WX_USER', 'SESS_KEY_WX_USER'); // 微信登录用户
define ('SESS_KEY_WX_CODE', 'SESS_KEY_WX_CODE'); // 微信微信静默授权code
define ('SESS_KEY_WX_USER_OPENID', 'SESS_KEY_WX_USER_OPENID'); // 微信微信静默授权openid
define ('SESS_KEY_PHONE_CODE', 'SESS_KEY_PHONE_CODE'); // 短信验证码

/**
 * ***************************** 其他通用 ******************************
 */
define ('THIRD_GROUP_TYPE_WX_JMDL', 1); // 第三方账号类型：微信静默登录

/**
 * ***************************** umeng推送系统 ******************************
 */
define ('UMENG_APPKEY', '5594940467e58e2d58002767'); // umeng第三方
define ('UMENG_MESSAGE_SECRET', 'qu2csq9nyevqhx81xdgqvz5rj44ghfz9'); // umeng第三方
/**
 * 商城项目根地址
 */
define('MALL_BASE_PATH','http://'.$_SERVER['HTTP_HOST']."/gw/")
?>