<template>
	<view class="container">
		<view>
			<view class="roombg-main">
				<swiper :autoplay="true" :interval="4000" :duration="150" class="fui-banner-swiper" :circular="true" @change="change">
					<swiper-item v-for="(item, index) in detail.slide" :key="index" class="fui-banner-item">
						<image :src="item" class="roombg" mode="widthFix" lazy-load />
					</swiper-item>
				</swiper>
				<!-- <image class="roombg" :src="detail.picture" mode="aspectFill"></image> -->
			</view>
			<view class="tsMeal">
				
			<view class="padding-lr-sm margin-top-sm">
				<fui-card title="opjiip" :full="true" :showHeader="false">
					<template v-slot:body>
						<view class="text-center padding-sm ">
							<view class="font-weight-600">{{ detail.name || '' }}</view>
							<!-- <view class="font-weight-600">{{ detail.name || '' }}{{detail.tip?'('+detail.tip+')':'' }}</view> -->
						</view>
						<view class="fui-flex margin-top24 margin-lr-lg">
							<view class="fui-col-10 fui-font-size_34 fui-flex">
								<view class="font-weight-200">{{ detail.price || '' }}元/小时</view>
							</view>
							<view class="typy_btn fui-col-2 fui-font-size_22 fui-color-white bag-color3 fui-center">{{ detail.status || '' }}</view>
						</view>
					</template>
					<template v-slot:footer>
						<fui-list-cell :lineLeft="false" padding="46rpx 46rpx 10rpx 46rpx" unlined>
							<view class="fui-item-box">
								<view class="fui-msg-box">
									<view class="fui-msg-box-left"><image class="fui-mybg-location" src="../../static/images/location.png" mode="widthFix"></image></view>
									<view class="fui-msg-item margin-left-lg" @click="getLocation">
										<view class="fui-msg-name">{{ houseDetail.address || '' }}</view>
									</view>
								</view>
								<view class="fui-msg-right">
									<view class="fui-msg-time" @click="goPhone"><image class="fui-mybg-btmg" src="../../static/images/call.png" mode="widthFix"></image></view>
								</view>
							</view>
						</fui-list-cell>
					</template>
				</fui-card>
			</view>
			<fui-divider :height="20"></fui-divider>
			<view class="fui-flex ">
				<scroll-view scroll-x="true">
					<view
						class="combo_type fui-col-4  fui-font-size_32 font-weight-600"
						v-for="(item, index) in comboType"
						:key="index"
						@click="goCombotype(item, index)"
						:class="{ combo_type_active: index === dynamic }"
					>
						{{ item.type === 2 ? item.type_str : item.duration + item.type_str }}
					</view>
				</scroll-view>
			</view>
			<view class="selectData">
				<fui-tea
					:top="24"
					:height="110"
					:currentTab="currentTab"
					itemWidth="50%"
					:tabs="weekdetail"
					bold
					:sliderWidth="62"
					:sliderHeight="7"
					color="#979E91"
					backgroundColor="#FFFFFF"
					selectedColor="#2FB278"
					sliderBgColor="#2FB278"
					@change="tabchange"
				></fui-tea>
				<view class="fui-flex padding-lr-lg  margin-top40" v-show="timeShow">
					<view class="start_time fui-center fui-font-size_32 border2 color margin-right-lg" @click="startTimes">{{ startTime }}</view>
					<view class="start_time fui-center fui-font-size_32 border3 margin-left-lg" @click="endTimeselect">{{ endTime }}</view>
				</view>
				<view class="fui-flex  margin-top40 fui-center fui-font-size_32" v-show="!timeShow">今天没有可选时间，请切换明天</view>
				<view class="fui-flex  margin-top10 color fui-font-size_24" v-show="timeShow">
					<view class="start_time_size fui-center margin-rig-l24">开始</view>
					<view class="start_time_size fui-center color13" style="margin-left: 60rpx;">结束</view>
				</view>
				<view class="margin-lr-auto" style="width: fit-content;">
					<view class="margin-top40">
						<!-- 24小时开始 -->
						<view class="fui-flex padding-lr-sm">
							<view class="text-left" v-for="index in 24" :key="index">
								<!-- @click="daySelectTime(index)" -->
								<view class="start_time_list" :class="{ active_user: active_color_user[index], active_notselect: notactive_color[index] }"></view>
								<view class="color9 time_order fui-font-size_19" :style="{ width: width + 'rpx;' }">{{ index }}</view>
							</view>
							<view class="color9 time_order_end fui-font-size_19">24</view>
						</view>
						<!-- 24小时结束 -->
						<!-- <view class="fui-flex">
							<view class="color9 fui-font-size_19" style="padding: 0 7rpx;" v-for="index in 25" :key="index">{{ index }}</view>
						</view> -->
						<view v-show="nextDay">
							<view class="color13 fui-font-size_24 margin-tb-xs">次日</view>
							<view class="fui-flex padding-lr-sm">
								<!-- @click="nextdaySelectTime(index)" -->
								<view v-for="index in 24" :key="index">
									<view class="start_time_list" :class="{ active_user: next_active_color_user[index], active_notselect: next_notactive_color[index] }"></view>
									<view class="color9 time_order fui-font-size_19" :style="{ width: width + 'rpx;' }">{{ index }}</view>
								</view>
								<view class="color9 time_order_end fui-font-size_19">24</view>
							</view>
						</view>
						<view class="predete_type fui-flex">
							<view class="fui-flex" v-for="(item, index) in typeList" :key="index">
								<view class="start_time_list_type margin-rig-6" :style="{ 'background-color': item.color }"></view>
								<view class="fui-font-size_24 color9 margin-rig-13">{{ item.name }}</view>
							</view>
						</view>
					</view>
				</view>
			</view>
			</view>
			<view class="fui-font-size_30 padding-lr-sm color">注：橙色为不可选时间</view>
			<fui-divider :height="20"></fui-divider>
			<view class="predeteDetail_meal" v-if="setmealDetails">
				<view class="fui-flex">
					<view class="predeteDetail_leftt"></view>
					<view class="color8 fui-font-size_30 font-weight-600 margin-left-xs">套餐说明</view>
				</view>
				<view class="margin-top20 text-intr color3 fui-font-size_30 line-height">{{ setmealDetails }}</view>
			</view>
			<view class="predeteDetail">
				<view class="fui-flex">
					<view class="predeteDetail_left"></view>
					<view class="color9 fui-font-size_30 font-weight-600 margin-left-xs">预定说明</view>
				</view>
				<view class="margin-top20 text-intr color3 fui-font-size_30 line-height">{{ detail.introduce }}</view>
			</view>
			<view class="yd-bottom fui-flex">
				<view class="fui-col-9 margin-left">
					<view class="fui-flex" v-if="Number(discount) === 0">
						<view class="color8 fui-font-size_26" @click="yhqSelect = true">选择使用卡券(可使用卡券{{ couponList.length }}张)</view>
					</view>
					<view class="fui-flex" v-if="Number(discount) != 0">
						<iconfont className="icon-hongbaokaquanhdpi" :size="15" color="#F68C40 "></iconfont>
						<view class="color8 fui-font-size_26" @click="yhqSelect = true">卡券优惠：￥{{ discount }}</view>
					</view>
					<view class="fui-font-size_28 ">
						需支付
						<text class="color text-bold fui-font-size_48">￥{{ prices }}</text>
					</view>
				</view>
				<view class="pay-btn text-white bag-color fui-col-3 text-bold fui-center margin-right" :style="{'margin-top':height}" v-if="timeShow" @click="goPay">{{ subText }}</view>
				<view class="pay-btn  text-white bag-colorus fui-col-3 text-bold fui-center margin-right tsBtn" v-else>{{ subText }}</view>
			</view>
			<!-- 开始时间 -->
			<fui-datetime
				ref="dateTime"
				:setDateTime="setDateTime"
				:type="type"
				:cancelColor="cancelColor"
				:color="color"
				:hours="hours"
				:minutes="minutes"
				:radius="radius"
				@confirm="startTimechange"
			></fui-datetime>
			<!-- 结束时间 -->
			<fui-datetime
				ref="dateTimeend"
				:setDateTime="setDateTime"
				:type="type"
				:cancelColor="cancelColor"
				:color="color"
				:hours="endHour"
				:minutes="minutes"
				:radius="radius"
				@confirm="endTimechange"
			></fui-datetime>

			<fui-modal :show="yhqSelect" @cancel="hide" :custom="true" fadeIn>
				<view v-if="couponList.length != 0" class="select_coupons_imag margin-bottom-xs" v-for="(item, index) in couponList" :key="index" @click="selectCoupon(item)">
					<view class="margin-lr-sm ">
						{{ item.coupon_name }}
						<text class="fui-font-size_22 margin-left-xs option">({{ item.type_str }})</text>
						<view class="margin-top-xs fui-font-size_22">{{ item.enable_start }} - {{ item.enable_end }}</view>
						<!-- <view class="fui-col-2"><view class="fui-center border-radius-20 fui-font-size_26" style="" >选择</view></view> -->
					</view>
				</view>
				<view class="text-df fui-center" v-if="couponList.length === 0">您还没有可使用优惠券</view>
			</fui-modal>
		</view>
		<view class="tsBtn"></view>
		<xky-guideStep :step="step" v-if="detail"></xky-guideStep>
	</view>
</template>

<script>
export default {
	data() {
		return {
			height:0,
			subText: '去支付',
			setmealDetails: '',
			current: 0,
			djprice: 0,
			width: 0,
			//套餐id
			combotID: 0,
			//卡券列表
			couponList: [],
			//卡券弹窗
			yhqSelect: false,
			// 实付金额
			prices: 0,
			//优惠价格
			discount: 0,
			//日期
			dataType: 0,
			//卡券id
			coupon_id: 0,
			//应付金额
			amount_payable: 0,
			//时间展示
			timeShow: true,
			//优惠券信息
			couponDetail: {},
			//时长卡时长
			coupon_time: 0,

			nextDay: false,
			detail: '',
			type: 4,
			startTime: '',
			endTime: '',
			cancelColor: '#888',
			color: '#218569',
			hours: [],
			minutes: [],
			endHour: [],
			disable: [],
			setDateTime: '',
			result: '',
			unitTop: false,
			radius: false,
			// 不可选 后台返回 操作橙色
			active_list: [],
			next_active_list: [],
			// 颜色控制数组 用户操作时间后显示的 不可选颜色
			notactive_color: [],
			next_notactive_color: [],

			// 选择的 用户操作（1、直接点，2、选择时间） 操作绿色
			active_user: [],
			next_active_user: [],
			// 颜色控制数组 用戶操作 操作绿色
			active_color_user: [],
			next_active_color_user: [],
			dynamic: 0,
			id: 0,
			comboType: [],
			currentTab: 0,
			typeList: [],
			weekdetail: [],
			houseDetail: {},
			//美团信息
			mtDetail: {},
			scene: false,

			step: {
				name: 'workbenchKey',
				guideList: [
					{
						el: '.tsMeal',
						tips: '第一步，选择时间和套餐',
						style: 'border-radius: 8rpx;margin: 0'
					},
					{
						el: '.tsBtn',
						tips: '第二步，选择优惠券后点击按钮下单',
						style: 'border-radius: 8rpx;margin: 0'
					}
				]
			}
		};
	},
	watch: {
		// id(val) {
		// 	if (val) {
		// 		let that = this;
		// 		that.init();
		// 	}
		// },
		prices(val) {
			if (Number(val) === 0) {
				this.subText = '去体验';
			}
		}
	},
	computed: {
		cssVars() {
		  return {
			"--height": this.height
		  };
		}
	},
	onLoad(option) {
		let that = this;
		console.log('option', option);
		if (that.$Route.query.scene) {
			let id = that.$Route.query.scene;
			that.meituanDetail(id);
			uni.setStorageSync('option', that.$Route.query.scene);
			that.scene = true;
		} else {
			that.id = option.id;
			if (option.id) {
				that.coupon_id = option.coupon_id;
			}
		}
		// console.log(that.active_list, that.next_active_list);
		// 动态计算尺寸
		uni.getSystemInfo({
			success: res => {
				this.statusBarHeight = res.statusBarHeight;
				const redio = (((res.windowWidth - uni.upx2px(40)) / 24) * 750) / res.windowWidth;
				this.width = redio;

				console.log('windowWidth', redio, res.windowWidth, uni.upx2px(40));
			}
		});

		console.log('this.$refs', this.$refs);
	},
	onShow(e) {
		console.log('option-e', e, this.id);
		let that = this;
		// 没有登录在onload里面写入缓存和id， 登录成功跳转进当前页面，使用缓存和id，
		if (uni.getStorageSync('option') && that.scene) {
			console.log('onShow', uni.getStorageSync('option'));
			that.id = uni.getStorageSync('option');
			that.meituanDetail(that.id);
		}
		
		if(that.id){
			that.init()
		}
		
		
		that.height=wx.getSystemInfoSync().windowHeight
		// that.$nextTick(function() {
		// 	that.getHoursedetail();
		// 	that.getCoupon();
		// 	that.initDayTime();
		// 	that.getinfomation();
		// });
	},
	methods: {
		init() {
			console.log('meituanDetail2')
			let that = this;
			that.getHoursedetail();
			that.getCoupon();
			that.initDayTime();
			that.getinfomation();
			// console.log('wx.clearStorage()',wx.clearStorage());
		},
		async meituanDetail(id) {
			let that = this;
			console.log('meituanDetail')
			const { data, code } = await that.fui.request(
				'diandi_tea/meituan/detail',
				'GET',
				{
					id: id
				},
				true
			);
			console.log('res-200', data, code);
			if (code === 200) {
				that.coupon_id = data.coupon_id;
				that.id = data.hourse_id;
				that.mtDetail = data;
				that.init()
			}
		},
		initDayTime() {
			let that = this;
			// 今天的数据初始化
			for (let i = 0; i < 24; i++) {
				// 初始化后台数据不可选的
				that.$set(that.active_list, i, false);
				// 初始化用户操作
				that.$set(that.active_user, i, false);

				// 初始化用戶操作綠色
				that.$set(that.active_color_user, i, false);
				// 初始化明天用戶操作綠色
				that.$set(that.next_active_color_user, i, false);

				// 初始化明天所有的操作
				that.$set(that.next_active_list, i, false);

				// 初始化明天的用户操作
				that.$set(that.next_active_user, i, false);

				// 初始化用戶操作綠色
				that.$set(that.active_color_user, i, false);
				// 初始化明天用戶操作綠色
				that.$set(that.next_active_color_user, i, false);
			}
		},
		getHoursedetail() {
			console.log('meituanDetail3')
			let that = this;
			that.modal = true;
			that.fui
				.request(
					'diandi_tea/order/hoursedetail',
					'POST',
					{
						hourse_id: that.id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						// that.djprice = res.data.setMeal[that.dynamic].price;
						if (res.data.disable[that.currentTab].disable.today_min.length === 0) {
							that.timeShow = false;
							that.nextDay = true;
						} else {
							that.timeShow = true;
						}
						that.setmealDetails = res.data.setMeal[that.dynamic].details;
						console.log('that.dynamic', that.dynamic);
						that.disable = res.data.disable;
						that.generateArray(res.data.disable[that.currentTab].disable.today_min);
						that.comboType = res.data.setMeal;
						that.detail = res.data.teaHourse;
						that.active_list = Object.values(res.data.disable[that.currentTab].disable.disable_hour_today);
						that.next_active_list = Object.values(res.data.disable[that.currentTab].disable.disable_hour_tomorrow);
						that.active_list.forEach((item, index) => {
							that.$set(that.notactive_color, item, true);
						});
						that.next_active_list.forEach((item, index) => {
							that.$set(that.next_notactive_color, item, true);
						});
						that.weekdetail = res.data.disable;

						//开始结束时间初始化
						that.startTime = res.data.disable[that.currentTab].disable.today_min[0];
						let date = new Date();
						let y = date.getFullYear();
						let titmDay = res.data.disable[that.currentTab].day;
						let titm = y + '/' + titmDay.replace('-', '/') + ' ' + that.startTime;
						let oldTime = new Date(titm).getTime();
						if (that.comboType[that.dynamic].duration == null) {
							that.endTime = '';
						} else {
							let endTime = oldTime / 1000 + that.comboType[that.dynamic].duration * 3600;
							that.endTime = that.iGlobal.formatDate(endTime, '{h}:{i}:{s}');
						}

						that.startGreen(res.data.disable[that.currentTab].disable.today_min[0], that.endTime);
						that.combotID = res.data.setMeal[that.dynamic].id;
						if (that.coupon_id != 0) {
							console.log('item.id', that.mtDetail, that.comboType);
							if (that.mtDetail.coupon) {
								// 循环所有套餐，一个房间三个套餐，扫码进来强制使用对应套餐，不能修改
								that.dynamic = that.comboType.findIndex(item=>that.mtDetail.coupon.meal_type === item.duration)
								that.combotID = res.data.setMeal[that.dynamic].id;
								// 卡券类型  1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券
								switch (that.mtDetail.coupon.type){
									case 1:
									// 代金券
										break;
									case 2:
									// 时长卡
										that.coupon_time = that.mtDetail.coupon.max_time * 3600000;
										break;
									case 3:
									// 次卡
										break;
									case 4:
									// 折扣券
										break;
									case 5:
									// 体验券
										break;
									default:
										break;
								}
								console.log('套餐数据',that.dynamic)
							}
							// that.prices = res.data.setMeal[that.dynamic].price;
						} else {
							console.log('初始价格',that.dynamic,res.data.setMeal);
							that.prices = res.data.setMeal[that.dynamic].price;
						}
						
						that.selectCoupon();
						console.log('that.combotID',that.combotID);
						that.InputToactiveTime();
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					console.log('shibai', res);
				});
		},
		// 选择时间图绿
		startGreen(startTime, endTime) {
			let that = this;
			let greeStart = startTime.split(':');
			let greeEnd = endTime.split(':');
			let num1 = Number(greeStart[0]);
			let num2 = Number(greeEnd[0]);
			if (num1 > num2) {
				that.nextDay = true;
				for (let i = 0; i < 23; i++) {
					if (i <= Number(that.endTime.split(':')[0])) {
						that.$set(that.next_active_color_user, i, true);
					}
				}
				for (let i = 0; i < 24; i++) {
					if (i >= num1) {
						that.$set(that.active_color_user, i, true);
					}
				}
			} else {
				that.nextDay = false;
				for (let i = 0; i < 24; i++) {
					if (i > num1 && i <= num2) {
						// console.log('item', i, Number(greeStart[0]), Number(greeEnd[0]));
						that.$set(that.active_color_user, i, true);
					}
				}
			}
		},
		// 日期切换
		tabchange(e) {
			let that = this;
			that.dataType = e.index;
			that.nextDay = false;
			that.active_color_user.forEach((item, idx) => {
				that.$set(that.active_color_user, idx, false);
			});
			for (let i = 0; i < 24; i++) {
				that.$set(that.next_active_color_user, i, false);
			}
			that.currentTab = e.index;
			that.getHoursedetail();
			that.notactive_color = [];
			that.next_notactive_color = [];
		},
		daySelectTime(index) {
			let that = this;
			that.$set(that.active_color_user, index, !that.active_color_user[index]);
			// 验证连续
			let acs = [];
			that.active_color_user.forEach((item, idx) => {
				if (item) {
					acs.push(idx);
				}
				// console.log('满足不这个条件1', that.active_color_user[index], idx >= index, acs.length > 1);
				if (!that.active_color_user[index] && idx >= index) {
					// console.log('满足不这个条件2');
					that.$set(that.active_color_user, idx, false);
				}
			});
			acs.forEach((v, k) => {
				if (acs[k] - 1 != acs[k - 1] && acs.length > 1 && k - 1 >= 0) {
					that.$set(that.active_color_user, index, false);
				}
			});
			that.activeToInputTime(acs[0], acs[acs.length - 1]);
		},
		nextdaySelectTime(index) {
			let that = this;
			that.$set(that.next_active_color_user, index, !that.next_active_color_user[index]);
			// 验证连续
			let acs = [];
			that.next_active_color_user.forEach((item, idx) => {
				if (item) {
					acs.push(idx);
				}
				if (!that.next_active_color_user[index] && idx >= index) {
					console.log('满足不这个条件2');
					that.$set(that.next_active_color_user, idx, false);
				}
			});
			acs.forEach((v, k) => {
				if (acs[k] - 1 != acs[k - 1] && acs.length > 1 && k - 1 >= 0) {
					that.$set(that.next_active_color_user, index, false);
				}
			});
			that.activeToInputTime(acs[0], acs[acs.length - 1]);
		},
		// 点击初始化选择时间初始化
		activeToInputTime(startTime, endTime) {
			let that = this;
			if (startTime || endTime) {
				that.startTime = startTime + ':00:00';
				that.endTime = endTime + ':00:00';
			}
			that.selectCoupon(that.couponDetail);
		},
		// 选择初始化点击
		InputToactiveTime() {
			let that = this;
			let timeList = [];
			let date = new Date();
			let y = date.getFullYear();

			let titmDay = that.weekdetail[0].day;
			let titm = y + '/' + titmDay.replace('-', '/') + ' ' + that.startTime;

			// let titm = y + '-' + that.weekdetail[0].day + ' ' + that.startTime;
			let oldTime = new Date(titm).getTime() / 1000;
			let hours = that.hours;
			hours.forEach((item, index) => {
				let itm = item;

				let titmDay = that.weekdetail[0].day;
				let dataTime = y + '/' + titmDay.replace('-', '/') + ' ' + itm + ':00:00';

				// let dataTime = y + '-' + that.weekdetail[0].day + ' ' + itm + ':00:00';
				let endTime = new Date(dataTime).getTime() / 1000;
				if (oldTime < endTime) {
					timeList.push(itm);
				}
			});
			that.endHour = timeList;
		},
		// 选择开始时间
		startTimechange(e) {
			console.log('e', e);
			let that = this;
			if (e.result === '00:00') {
				return false;
			}
			that.active_color_user.forEach((item, idx) => {
				that.$set(that.active_color_user, idx, false);
			});
			let greeStart = that.endTime.split(':');
			that.startTime = e.result + ':00';
			let date = new Date();
			let y = date.getFullYear();

			let titmDay = that.weekdetail[0].day;
			let titm = y + '/' + titmDay.replace('-', '/') + ' ' + e.result;

			// let titm = y + '-' + that.weekdetail[0].day + ' ' + e.result;
			let oldTime = new Date(titm).getTime();
			let endTime = oldTime / 1000 + that.comboType[that.dynamic].duration * 3600;
			that.endTime = that.iGlobal.formatDate(endTime, '{h}:{i}:{s}');
			// console.log('that.endTime', that.startTime, that.endTime, e.hour);
			that.InputToactiveTime();
			if (Number(greeStart[0]) < Number(e.hour)) {
				that.nextDay = true;
				for (let i = 0; i < 24; i++) {
					if (i <= Number(that.endTime.split(':')[0])) {
						that.$set(that.next_active_color_user, i, true);
					}
				}
			}
			that.hours.forEach((item, index) => {
				if (item <= e.hour) {
					that.$set(that.active_color_user, Number(e.hour) + 1, true);
				}
			});
			that.selectCoupon(that.couponDetail);
		},
		// 选择结束时间
		endTimechange(e) {
			let that = this;
			if (e.result === '00:00') {
				return false;
			}
			that.endTimeChange = true;
			that.active_color_user.forEach((item, idx) => {
				that.$set(that.active_color_user, idx, false);
			});
			that.endTime = e.result + ':00';
			let start = that.startTime.split(':');
			that.hours.forEach((item, index) => {
				if (item < e.hour && item > start[0]) {
					that.$set(that.active_color_user, item, true);
				}
			});
			that.comboType.forEach((item, index) => {
				if (item.type === 2) {
					that.goCombotype(item, index);
				}
			});
			that.selectCoupon(that.couponDetail);
		},
		// 套餐切换
		goCombotype(item, index) {
			let that = this;
			that.subText = '去支付';
			that.combotID = item.id;
			console.log('item', item, that.comboType, that.currentTab);
			that.discount = 0;
			that.nextDay = false;
			that.dynamic = index;
			that.active_color_user.forEach((item, idx) => {
				that.$set(that.active_color_user, idx, false);
			});
			for (let i = 0; i < 24; i++) {
				that.$set(that.next_active_color_user, i, false);
			}
			if (item.type === 2) {
				// let coupon = [];
				// that.couponList.forEach((item, index) => {
				// 	if (item.coupon_type === 5) {
				// 		coupon.push(item);
				// 		that.couponList = coupon;
				// 	}
				// });
				that.setmealDetails = that.comboType[that.dynamic].details;
				that.startGreen(that.disable[that.currentTab].disable.today_min[0], that.endTime);
				// 优惠券跟着切换套餐走
				that.selectCoupon(that.couponDetail);
			} else {
				that.prices = that.comboType[index].price;
				that.getHoursedetail();
			}
		},
		//选择优惠券 计算金额
		selectCoupon(couponDetail = {}) {
			let that = this;
			console.log('that.combotID2',that.combotID);
			that.couponDetail = couponDetail;
			if (couponDetail.coupon_id && couponDetail) {
				that.coupon_id = couponDetail.coupon_id;
			}
			let date = new Date();
			let y = date.getFullYear();
			let titm = y + '-' + that.disable[that.dataType].day + ' ' + that.startTime;
			that.fui
				.request(
					'diandi_tea/order/charging',
					'POST',
					{
						set_meal_id: that.combotID,
						coupon_id: that.coupon_id,
						start_time: titm,
						end_time: that.endTime
					},
					true
				)
				.then(res => {
					console.log('res', res);
					if (res.code === 200) {
						that.prices = res.data.real_pay;
						that.discount = res.data.discount;
						that.amount_payable = res.data.amount_payable;
						that.yhqSelect = false;
						if (couponDetail.type_str === '时长卡'  && couponDetail) {
							that.coupon_time = couponDetail.max_time * 3600000;
							console.log('that.coupon_time', that.coupon_time);
						}
					} else {
						that.yhqSelect = false;
						uni.showToast({
							title: res.message,
							icon: 'none',
							duration: 3000
						});
					}
				})
				.catch(res => {
					that.yhqSelect = false;
					console.log('res.message', res.message);
					uni.showToast({
						title: res.message,
						icon: 'none',
						duration: 3000
					});
				});
		},
		// 开始时间初始化
		generateArray(time_min) {
			let that = this;
			let timeHours = [];
			let timeMinutes = [];
			time_min.forEach((item, index) => {
				let timeArr = item.split(':');
				timeHours.push(Number(timeArr[0]));
				timeMinutes.push(Number(timeArr[1]));
			});
			let set1 = new Set(timeHours);
			let set2 = new Set(timeMinutes);
			that.hours = [...set1];
			that.endHour = [...set1];
			const minutes = [...set2];
			console.log('that.minutes', that.minutes);
			that.minutes = minutes.sort(function(a, b) {
				return a - b;
			});
			// that.genendTimeArray();
		},
		// 结束时间初始化
		// genendTimeArray() {
		// 	let that = this;
		// 	let tomorendTime = that.disable[that.dataType].disable.tomorrow_min;
		// 	let tomortimeHours = [];
		// 	tomorendTime.forEach((item, index) => {
		// 		let timeArr = item.split(':');
		// 		tomortimeHours.push(Number(timeArr[0]));
		// 	});
		// 	let tomorset = new Set(tomortimeHours);
		// 	let tomorTime = [...tomorset];
		// 	tomorTime.forEach((item, index) => {
		// 		that.endHour.push('次日' + item);
		// 	});
		// },
		//获取优惠券
		getCoupon() {
			let that = this;
			that.fui
				.request('diandi_tea/order/choosecoupon', 'POST', { hourse_id: that.id }, true)
				.then(res => {
					if (res.code === 200) {
						that.couponList = res.data;
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				});
		},
		// 去支付
		goPay() {
			let that = this;
			let date = new Date();
			let y = date.getFullYear();
			let titm = y + '/' + that.disable[that.dataType].day.replace('-', '/') + ' ' + that.startTime;
			let a_endTitm = y + '/' + that.disable[that.dataType].day.replace('-', '/') + ' ' + that.endTime;
			let e_endTitm = '';
			console.log('timecs', that.coupon_time, titm);
			//判断是否使用时长券
			if (that.coupon_time != 0) {
				let d_endTime = new Date(a_endTitm).getTime() + that.coupon_time;
				e_endTitm = that.iGlobal.formatDate(d_endTime, '{h}:{i}:{s}');
			} else {
				e_endTitm = that.endTime;
			}
			console.log('加时间', that.endTime);
			that.fui
				.request(
					'diandi_tea/order/createorder',
					'POST',
					{
						set_meal_id: that.combotID,
						coupon_id: that.coupon_id,
						start_time: titm,
						end_time: e_endTitm,
						amount_payable: that.amount_payable,
						discount: that.discount,
						real_pay: that.prices,
						order_type: 1,
						hourse_id: that.id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						// let id = res.data.id;
						// uni.showToast({
						// 	title: '下单成功',
						// 	icon: 'none',
						// 	duration: 3000
						// });
						uni.showToast({
							title: res.message,
							icon: 'none',
							duration: 3000
						});
						that.selectPay(res.data);

						// that.$Router.push({
						// 	name: 'confirmOrder',
						// 	params: {
						// 		id: id
						// 	}
						// });
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				});
		},
		// 支付为零
		selectPay(item) {
			let that = this;
			console.log('item', item);
			let id = item.id;
			if (Number(that.prices) === 0) {
				that.fui
					.request(
						'diandi_tea/notify/notify',
						'POST',
						{
							out_trade_no: item.order_number
						},
						true
					)
					.then(res => {
						if (res.code === 200) {
							uni.redirectTo({
								url: '/teahouse/orderDetail/orderDetail?id=' + id
							});
							// uni.redirectTo({
							//      url: '/teahouse/orderDetail/orderDetail?id='+that.orderDetail.id
							// });
						} else {
							uni.showToast({
								title: res.message,
								icon: 'none'
							});
						}
					})
					.catch(res => {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					});
			} else {
				that.$Router.push({
					name: 'confirmOrder',
					params: {
						id: id
					}
				});
			}
		},
		startTimes(e) {
			let that = this;
			console.log('that.$refs', that);
			that.$refs.dateTime.show();
		},
		endTimeselect(e) {
			let that = this;
			that.$refs.dateTimeend.show();
		},
		hide() {
			this.yhqSelect = false;
		},
		getinfomation() {
			let that = this;
			that.fui
				.request('diandi_tea/index/top', 'GET', {}, false)
				.then(res => {
					if (res.code === 200) {
						that.houseDetail = res.data.list;
						console.log(res);
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				});
		},
		//导航
		getLocation() {
			let that = this;
			wx.getLocation({
				type: 'gcj02',
				success: function(res) {
					wx.openLocation({
						//​使用微信内置地图查看位置。
						latitude: Number(that.houseDetail.latitude), //要去的纬度-地址
						longitude: Number(that.houseDetail.longitude), //要去的经度-地址
						name: that.houseDetail.name
						// address: '华侨城商业中心'
					});
				}
			});
		},
		goPhone() {
			let that = this;
			wx.makePhoneCall({
				phoneNumber: that.houseDetail.mobile
			});
		},
		change: function(e) {
			this.current = e.detail.current;
		}
	}
};
</script>

<style>
.fui-banner-swiper {
	width: 100%;
	height: 367.89rpx;
}
.fui-banner-item {
	box-sizing: border-box;
}
.roombg-main {
	width: 100%;
	height: 350rpx;
}
.roombg {
	width: 100%;
	height: 367.89rpx;
}
.yd-bottom {
	border-top: 1.02rpx solid #d8d8d8;
	height: 163.26rpx;
	bottom: 0;
	position: fixed;
	width: 100%;
	z-index: 2;
	background-color: #ffffff;
}
.pay-btn {
	font-size: 38.77rpx;
	border-radius: 45.91rpx;
	width: 251.02rpx;
	height: 91.83rpx;
}
.fui-msg-item {
	max-width: 500rpx;
	min-height: 80rpx;
	overflow: hidden;
	display: grid;
	flex-direction: column;
	justify-content: space-between;
	align-items: center;
}
.fui-msg-box-left,
.fui-msg-right {
	min-height: 80rpx;
	display: grid;
	align-items: center;
}
.fui-mybg-location {
	width: 40rpx;
}
.fui-mybg-btmg {
	width: 40rpx;
	/* height: 35rpx; */
}
.typy_btn {
	width: 114.28rpx;
	height: 36.73rpx;
	border-radius: 18.36rpx;
}
.fui-msg-box-left {
	min-height: 80rpx;
}
.fui-msg-name {
	overflow: hidden;
	text-overflow: ellipsis;
	font-size: 25rpx;
	line-height: 40rpx;
	white-space: inherit;
	color: #262b3a;
}
.combo_type {
	height: 105.1rpx;
	display: inline-block;
	text-align: center;
	line-height: 105.1rpx;
}
.combo_type_active {
	background-color: #f5f8f2;
	color: #2fb278;
}
.selectData {
	background-color: #ffffff;
	width: 100%;
	height: max-content;
	margin-bottom: 40rpx;
}
.start_time {
	width: 306.12rpx;
	height: 69.38rpx;
	border-radius: 38.77rpx;
}
.start_time_size {
	width: 306.12rpx;
}
.start_time_list {
	/* width: 26.1rpx; */
	height: 30.61rpx;
	border: 1.02rpx solid #d2d2d2;
	background-color: #218569;
}
.start_time_list_type {
	width: 24.48rpx;
	height: 24.48rpx;
	border: 1.02rpx solid #d2d2d2;
}
.predeteDetail {
	margin: 32.65rpx 33.12rpx 251.02rpx 33.12rpx;
}
.predeteDetail_meal {
	margin: 32.65rpx 33.12rpx 20rpx 33.12rpx;
}
.predeteDetail_left {
	width: 7.14rpx;
	height: 28.57rpx;
	background: #218569;
	border-radius: 4.08rpx;
}
.predeteDetail_leftt {
	width: 7.14rpx;
	height: 28.57rpx;
	background: #f68c40;
	border-radius: 4.08rpx;
}
.predete_type {
	margin-top: 26.53rpx;
	position: absolute;
	right: 12.81rpx;
}
scroll-view {
	width: 100%;
	height: 105.1rpx;
	white-space: nowrap;
}
.active_user {
	/* background: #160bb2; */
}
.active_notselect {
	background: #f79730;
}
.fui-modal-mask {
	background-color: rgba(216, 216, 216, 0.8) !important;
}
.fui-number-box {
	width: 100%;
	box-sizing: border-box;
	margin-bottom: 20rpx;
	background: #fff;
	display: flex;
	font-size: 26.53rpx;
	align-items: center;
	justify-content: space-between;
}
.select_coupons_imag {
	width: 505.16rpx;
	background-color: #218569;
	color: #ffffff;
	border-radius: 11rpx;
	padding: 30rpx 0;
}
.time_order {
	position: relative;
	left: -6rpx;
}
.time_order_end {
	display: inline-flex;
	position: relative;
	right: 7rpx;
	top: 17rpx;
}
.text-intr {
	white-space: break-spaces;
	line-height: 45rpx;
}
.house_address {
	background: #ffffff;
	box-shadow: 0rpx 7rpx 20rpx 0rpx rgba(229, 234, 224, 1);
	border-radius: 12rpx;
}
.tea-navigation {
	width: 63rpx;
	height: 69rpx;
}
.tsBtn{
	height: 180rpx;
	top: var(--height);
}
</style>
