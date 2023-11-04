/*
 * @Descripttion: 
 * @version: 1.0
 * @Author: sanhui
 * @Date: 2022-01-15 17:41:08
 */
/**
 * 返回读取的文件信息
 * files 用import.meta.globEager读取到的files
 * modules 是否按照文件为模块返回
 * js 要获取的文件后缀
*/
export function getModules({
    files,
    modules = false,
    ext = 'js'
}) {
    const resModules = {};
    for (const key in files) {
        if (Object.prototype.hasOwnProperty.call(files, key)) {
            if (modules) {
                resModules[basename(key, `.${ext}`)] = files[key].default
            } else {
                Object.assign(resModules, files[key].default);
            }
        }
    }
    return resModules
}

function basename(path, ext) {
    return path.split(ext).shift().split('/').pop()
}