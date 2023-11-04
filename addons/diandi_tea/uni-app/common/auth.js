import WechatJSSDK from "wechat-jssdk/dist/client.umd"; //WechatJSSDK(result)
import {
	getWechatConfig,
	wechatAuth
} from '@/api/public';
let instance, wechatObj;
export default function wechat() {
	return new Promise((resolve, reject) => {
		getWechatConfig()
			.then(res => {
				resolve(res.data);
			})
			.catch(err => {
				reject(err);
			});
	});
}

export function toAuth() {
	wechat().then(res => {
		location.href = getAuthUrl(res.appId);
	});
}
// 获取微信公众号授权地址
function getAuthUrl(appId) {
	const redirect_uri = encodeURIComponent(`${location.origin}/auth`);
	const state = encodeURIComponent(
		("" + Math.random()).split(".")[1] + "authorizestate"
	);
	return `https://open.weixin.qq.com/connect/oauth2/authorize?appid=${appId}&redirect_uri=${redirect_uri}&response_type=code&scope=snsapi_userinfo&state=${state}#wechat_redirect`;
}
