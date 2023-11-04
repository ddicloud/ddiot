/*
 * @Descripttion: 
 * @version: 1.0
 * @Author: sanhui
 * @Date: 2021-09-11 11:34:57
 */

export default class RefreshToken {
    isRefresh = false;
    isChangeDomain = false;
    tasks = [];
    notifyTaskReload(isError = false) {
        while (this.tasks.length) {
            this.tasks.shift()(isError)
        }
    }
    clearTask() {
        this.notifyTaskReload(true)
    }
    setRefreshType(type) {
        this.isRefresh = type
    }
    setDomainType(type) {
        this.isChangeDomain = type
    }
    addTask(fn) {
        this.tasks.push(fn)
    }
    static initRefreshToken() {
        return new RefreshToken()
    }
}
