/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-30 16:26:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-11 10:35:54
 */
import LoginIndex from './index'
import LoginRegister from './register'
import LoginForget from './forget'
import LoginQcord from './qcord.vue'
import LoginAuthRedirect from './auth-redirect.vue'
const LoginMap = {
  'login-index': LoginIndex,
  'login-register': LoginRegister,
  'login-forget': LoginForget,
  'login-qcord': LoginQcord,
  'login-auth-redirect': LoginAuthRedirect
}

export default LoginMap
