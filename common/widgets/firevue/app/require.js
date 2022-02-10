/// 全局组件自动配置  START
const requireComponent = require.context(
    // 其组件目录的相对路径
    "./components",
    // 是否查询其子目录
    true,
    // 匹配基础组件文件名的正则表达式
    /\w.(vue|js)/
  );
  
  // For each matching file name...  对应每个匹配的文件名
  requireComponent.keys().forEach(fileName => {
    // Get the component config  获取组件配置
    const componentConfig = requireComponent(fileName);
  
    // 获取组件的 PascalCase 命名
    // 获取和目录深度无关的文件名 (获取组件的组件名)
    const componentName = fileName
      .split("/")
      .pop()
      .replace(/\.\w+$/, "");
  
    // Globally register the component  全局注册组件
    Vue.component(
      componentName,
      // 如果这个组件选项是通过 `export default` 导出的，
      // 那么就会优先使用 `.default`，
      // 否则回退到使用模块的根。
      componentConfig.default || componentConfig
    );
  });
  /// 全局组件自动配置  END