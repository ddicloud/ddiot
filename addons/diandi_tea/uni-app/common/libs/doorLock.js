// 引入插件
var Plugin = requirePlugin("BLELockSDK");
// 定义数据
var config = {
  keyGroupId: 903,
  lockMac: "806fb05189e0",
  secret: "cj8CO8PWkBdS6EcG",
  authCode: "59d13a2d",
  lockName: "Lock_c3e3",
  loginToken: "+OEit7xxWiB75mAs7Nc65w=="
};

Page({
  onReady: function() {
    this.plugin = new Plugin({
      // authCode: config.authCode,
      // secret: config.secret,
      // lockMac: config.lockMac,
      keyGroupId: config.keyGroupId
    });

    // 监听“初始化完成”事件
    this.plugin.on("ready", function(plugin) {
      console.info("plugin is on ready", plugin);
    });

    // 监听“断开连接”事件
    this.plugin.on("close", function(state) {
      console.info("plugin is on close, state -->", state);
    });

    // 监听“运行错误”事件
    this.plugin.on("error", function(err) {
      console.info("plugin is on error -->", err);
    });

    // 监听“开锁”事件上报
    this.plugin.on("report:openLock", function(data) {
      console.info("plugin is on opened lock, data is ", data);
    });

    // 监听“钥匙的使能与禁止”事件上报
    this.plugin.on("report:enableKey", function(data) {
      console.info("plugin is on enabled key, data is ", data);
    });

    // 监听“删除钥匙”事件上报
    this.plugin.on("report:removeKey", function(data) {
      console.info("plugin is on remove key, data is ", data);
    });

    // 监听“添加钥匙”事件上报
    this.plugin.on("report:addKey", function(data) {
      console.info("plugin is on add key, data is ", data);
    });

    // 监听“设置系统参数”事件上报
    this.plugin.on("report:setSystemInfo", function(data) {
      console.info("plugin is on set system info, data is ", data);
    });

    // 监听“修改密码”事件上报
    this.plugin.on("report:updatePassword", function(data) {
      console.info("plugin is on updating password, data is ", data);
    });
  },

  // 开锁
  openLock: function() {
    this.plugin
      .openLock()
      .then(res => {
        console.log("openLock res -->", res);
      })
      .catch(err => {
        console.log("openLock res -->", res);
      });
  },

  // 获取广播数据
  getBroadcastData: function() {
    this.plugin
      .getBroadcastData()
      .then(function(res) {
        console.log("getBroadcastData res -->", res);
      })
      .catch(function(err) {
        console.log("getBroadcastData err -->", err);
      });
  },

  // 添加蓝牙设备
  addBluetoothDevice: function() {
    this.plugin
      .addBluetoothDevice()
      .then(function(res) {
        console.log("addBluetoothDevice res -->", res);

        // 解析密钥
        var s = "";
        for (
          var i = 0, aes = res.data.DNAInfo.aesKey, l = aes.length;
          i < l;
          i = i + 2
        ) {
          var a = aes[i] + aes[i + 1];

          s += String.fromCharCode(`0x${a}`);
        }

        console.log("aesKey ------------>", s);
      })
      .catch(function(err) {
        console.log("addBluetoothDevice err -->", err);
      });
  },

  // 校验门锁初始信息
  validateLockInitialInfo: function() {
    this.plugin
      .validateLockInitialInfo({
        isSuccess: true
      })
      .then(function(res) {
        console.log("validateLockInitialInfo res -->", res);
      })
      .catch(function(err) {
        console.log("validateLockInitialInfo err -->", err);
      });
  },

  // 同步门锁系统时间
  synchronizeLockSystemTime: function() {
    this.plugin
      .synchronizeLockSystemTime()
      .then(function(res) {
        console.log("synchronizeLockSystemTime res -->", res);
      })
      .catch(function(err) {
        console.log("synchronizeLockSystemTime err -->", err);
      });
  },

  // 读取DNA信息
  readDNAInfo: function() {
    this.plugin
      .readDNAInfo()
      .then(function(res) {
        console.log("readDNAInfo res -->", res);
      })
      .catch(function(err) {
        console.log("readDNAInfo err -->", err);
      });
  },

  // 读取系统参数
  readSystemInfo: function() {
    this.plugin
      .readSystemInfo()
      .then(function(res) {
        console.log("readSystemInfo res -->", res);
      })
      .catch(function(err) {
        console.log("readSystemInfo err -->", err);
      });
  },

  // 设置系统参数
  setSystemInfo: function() {
    this.plugin
      .setSystemInfo({
        openMode: 1,
        normallyOpenMode: 1,
        volumeEnable: 1,
        systemVolume: 1,
        shackleAlarmEnable: 1,
        lockCylinderAlarmEnable: 1,
        antiLockEnable: 1,
        lockCoverAlarmEnable: 1,
        systemLanguage: 1
      })
      .then(function(res) {
        console.log("setSystemInfo res -->", res);
      })
      .catch(function(err) {
        console.log("setSystemInfo err -->", err);
      });
  },

  // 钥匙的使能与禁止
  enableKey: function() {
    this.plugin
      .enableKey({
        mode: 1,
        lockKeyId: 11,
        value: true

        // mode: 2,
        // value: {
        //   password: true,
        // }

        // mode: 3,
        // keyGroupId: config.keyGroupId,
        // value: true
      })
      .then(function(res) {
        console.log("enableKey res -->", res);
      })
      .catch(function(err) {
        console.log("enableKey err -->", err);
      });
  },

  // 添加钥匙
  addKey: function() {
    // 有效日期
    var validStartTime = new Date("2018-12-24");
    validStartTime.setHours(9, 12, 23);
    validStartTime = Math.floor(validStartTime.getTime() / 1000);

    // 结束日期
    var validEndTime = new Date("2019-12-25");
    validEndTime.setHours(9, 12, 23);
    validEndTime = Math.floor(validEndTime.getTime() / 1000);

    var lockKeyId = 888; // 钥匙ID由设备分配
    var keyGroupId = config.keyGroupId; // 用户组ID
    var usageCount = 30; // 使用次数

    var options1 = {
      lockKeyId,
      keyGroupId,
      validStartTime,
      validEndTime,
      usageCount,

      type: 0, // 按指定的钥匙类型添加
      keyType: 2, // 卡片类型
      validTimeMode: 0 // 时间模式为有效期类型
    };
    // this.plugin
    //   .addKey(options1)
    //   .then(function(res) {
    //     console.log("addKey1 res -->", res);
    //   })
    //   .catch(function(err) {
    //     console.log("addKey1 err -->", err);
    //   });

    var options2 = {
      lockKeyId,
      keyGroupId,
      validStartTime,
      validEndTime,
      usageCount,

      type: 1, // 按内容添加
      keyType: 1, // 密码类型
      validTimeMode: 0, // 时间模式为有效期类型
      key: "123123" // 内容值

      // validTimeMode: 1, // 时间模式为重复周期类型
      // dayStartTime: 10 * 60, // 起始分钟数
      // dayEndTime: 22 * 60, // 结束分钟数
      // weeks: [1, 2, 3, 4] // 每周的周二、周四、周五
    };

    this.plugin
      .addKey(options2)
      .then(function(res) {
        console.log("addKey2 res -->", res);
      })
      .catch(function(err) {
        console.log("addKey2 err -->", err);
      });
  },

  // 删除钥匙
  removeKey: function() {
    this.plugin
      .removeKey({
        mode: 0,
        lockKeyId: 11,
        keyType: [1]

        // mode: 1,
        // keyType: [1, 2]

        // mode: 2,
        // keyType: [1],
        // key: '123123',

        // mode: 3,
        // keyGroupId: config.keyGroupId
      })
      .then(function(res) {
        console.log("removeKey res -->", res);
      })
      .catch(function(err) {
        console.log("removeKey err -->", err);
      });
  },

  // 修改密码
  updatePassword: function() {
    this.plugin
      .updatePassword({
        newPassword: "222223",
        lockKeyId: 11
      })
      .then(function(res) {
        console.log("updatePassword res -->", res);
      })
      .catch(function(err) {
        console.log("updatePassword err -->", err);
      });
  },

  // 解除报警
  releaseAlarm: function() {
    this.plugin
      .releaseAlarm({
        releaseAlarmType: 255
      })
      .then(function(res) {
        console.log("releaseAlarm res -->", res);
      })
      .catch(function(err) {
        console.log("releaseAlarm err -->", err);
      });
  },

  // 同步钥匙列表
  synchronizeKeyList: function() {
    this.plugin
      .synchronizeKeyList()
      .then(function(res) {
        console.log("synchronizeKeyList res -->", res);
      })
      .catch(function(err) {
        console.log("synchronizeKeyList err -->", err);
      });
  },

  // 删除蓝牙设备
  removeBluetoothDevice: function() {
    this.plugin
      .removeBluetoothDevice()
      .then(function(res) {
        console.log("removeBluetoothDevice res -->", res);
      })
      .catch(function(err) {
        console.log("removeBluetoothDevice err -->", err);
      });
  },

  // 同步门锁记录
  synchronizeRecords: function() {
    this.plugin
      .synchronizeLockRecord()
      .then(function(res) {
        console.log("synchronizeLockRecord res -->", res);
      })
      .catch(function(err) {
        console.log("synchronizeLockRecord err -->", err);
      });
  },

  // 添加远程控制
  addRemoteControl: function() {
    this.plugin
      .addRemoteControl({
        type: "NB",
        tokenId: config.loginToken
      })
      .then(function(res) {
        console.log("addRemoteControl res -->", res);
      })
      .catch(function(err) {
        console.log("addRemoteControl err -->", err);
      });
  }
});