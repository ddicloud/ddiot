/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-26 11:05:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-29 16:55:01
 */
const { notEmpty } = require('../utils.js')

module.exports = {
  description: 'generate vue component',
  prompts: [{
    type: 'input',
    name: 'name',
    message: 'component name please',
    validate: notEmpty('name')
  },
  {
    type: 'checkbox',
    name: 'blocks',
    message: 'Blocks:',
    choices: [{
      name: '<template>',
      value: 'template',
      checked: true
    },
    {
      name: '<script>',
      value: 'script',
      checked: true
    },
    {
      name: 'style',
      value: 'style',
      checked: true
    }
    ],
    validate(value) {
      if (value.indexOf('script') === -1 && value.indexOf('template') === -1) {
        return 'Components require at least a <script> or <template> tag.'
      }
      return true
    }
  }
  ],
  actions: data => {
    const name = '{{properCase name}}'
    const actions = [{
      type: 'add',
      path: `src/components/${name}/index.vue`,
      templateFile: 'plop-templates/component/index.hbs',
      data: {
        name: name,
        template: data.blocks.includes('template'),
        script: data.blocks.includes('script'),
        style: data.blocks.includes('style')
      }
    }]

    return actions
  }
}
