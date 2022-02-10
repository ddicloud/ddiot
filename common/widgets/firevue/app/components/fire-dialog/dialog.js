/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-05 16:03:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-11-11 16:30:23
 */
import SyDialog from './fire-dialog'
import Vue from 'vue'

const SyDialogConstructor = Vue.extend(SyDialog)

const dialog = (opts = {}) => {
  let _a = new SyDialogConstructor({el: document.createElement('div')})
  _a.title = opts.title || '标题'
  _a.url = opts.url || ''
  _a.param = opts.param || {}
  _a.visible = true

  renderBtns(_a,opts.btns || [])
  renderCloseCallBack(opts)
  document.body.appendChild(_a.$el)
  return new Promise(resolve => {
    return (
      _a.close = () => {
        _a.visible = false
        opts.closeCallBack()
        resolve()
      })
  })
}

function renderCloseCallBack(opts) {
  opts.closeCallBack = opts.closeCallBack || function () {}
}


function renderBtns(_a, btns) {
  _a.btns = []
  let getName = function (btn) {
    let name = btn.click.name || 'click'
    i++;
    return name + i;
  }

  let i = 0;
  for (let btn of btns) {
    const name = btn.name || '按钮'
    const clickEventName = getName(btn)
    const func = btn.click || function(){alert(666)}
    _a.btns.push({
      name: name,
      clickEventName: clickEventName,
      func: func
    })
  }
}
export default dialog

