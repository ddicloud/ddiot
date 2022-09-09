const pluginName = 'diandiConfigPlugin'
const fs = require('fs')
const path = require('path')

module.exports = class diandiConfigPlugin {
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
