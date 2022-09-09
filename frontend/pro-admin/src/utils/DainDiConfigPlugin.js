/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-12 14:16:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-13 20:50:50
 */

const pluginName = 'DainDiConfigPlugin'
const fs = require('fs')
const path = require('path')

module.exports = class DainDiConfigPlugin {
  constructor(options) {
    this.options = options
  }
  apply(compiler) {
    const fileOptions = this.options
    compiler.hooks.beforeRun.tap(pluginName, compilation => {
      if (Array.isArray(fileOptions)) {
        for (let i = 0; i < fileOptions.length; i++) {
          const outputPath = path.join(fileOptions[i].path, fileOptions[i].fileName)
          fs.writeFile(outputPath, fileOptions[i].content, function(err) {
            if (err) {
              return console.error(err)
            }
            console.log(`${fileOptions[i].fileName} written successfully.`)
          })
        }
      }
    })
  }
}
