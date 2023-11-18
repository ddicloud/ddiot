import sendHttp from "@/uni_modules/ddiot-ui/js_sdk/http/index.js"
export function integralMemberInfo() {
	return sendHttp('/diandi_integral/member/info', "GET", {}, true)
}
export function integralIndexIndex() {
	return sendHttp('/diandi_integral/index/index', "POST", {}, true)
}
export function integralStoreInfo() {
	return sendHttp('/diandi_integral/store/info', "GET", {}, true)
}
export function integralStoreDistance() {
	return sendHttp('/diandi_integral/store/distance', "GET", {}, true)
}
export function integralHelpDetail() {
	return sendHttp('/diandi_integral/help/detail', "POST", {}, true)
}
export function integralHelpLists() {
	return sendHttp('/diandi_integral/help/lists', "GET", {}, true)
}
export function integralOrderCreateorder() {
	return sendHttp('/diandi_integral/order/createorder', "POST", {}, true)
}
export function integralOrderList() {
	return sendHttp('/diandi_integral/order/list', "POST", {}, true)
}
export function integralOrderDetail() {
	return sendHttp('/diandi_integral/order/detail', "POST", {}, true)
}
export function integralOrderOrderdetail() {
	return sendHttp('/diandi_integral/order/orderdetail', "GET", {}, true)
}
export function integralOrderConfirm() {
	return sendHttp('/diandi_integral/order/confirm', "POST", {}, true)
}
export function integralOrderCreategoodsorder() {
	return sendHttp('/diandi_integral/order/creategoodsorder', "POST", {}, true)
}
export function integralOrderExchange() {
	return sendHttp('/diandi_integral/order/exchange', "POST", {}, true)
}
export function integralOrderExchangelist() {
	return sendHttp('/diandi_integral/order/exchangelist', "GET", {}, true)
}
export function integralGoodsLists() {
	return sendHttp('/diandi_integral/goods/lists', "GET", {}, true)
}
export function integralGoodsSearch() {
	return sendHttp('/diandi_integral/goods/search', "GET", {}, true)
}
export function integralGoodsDetail() {
	return sendHttp('/diandi_integral/goods/detail', "GET", {}, true)
}
export function integralGoodsGetslide() {
	return sendHttp('/diandi_integral/goods/getslide', "GET", {}, true)
}
export function integralCategoryList() {
	return sendHttp('/diandi_integral/category/list', "GET", {}, true)
}
export function integralCommentComment() {
	return sendHttp('/diandi_integral/comment/comment', "POST", {}, true)
}
export function integralCommentList() {
	return sendHttp('/diandi_integral/comment/list', "GET", {}, true)
}
export function integralAreasList() {
	return sendHttp('/diandi_integral/areas/list', "POST", {}, true)
}
export function integralAddressGetdefault() {
	return sendHttp('/diandi_integral/address/getdefault', "POST", {}, true)
}
export function integralAddressSetdefault() {
	return sendHttp('/diandi_integral/address/setdefault', "POST", {}, true)
}
export function integralAddressLists() {
	return sendHttp('/diandi_integral/address/lists', "POST", {}, true)
}
export function integralAddressDeletes() {
	return sendHttp('/diandi_integral/address/deletes', "POST", {}, true)
}
export function integralAddressDetail() {
	return sendHttp('/diandi_integral/address/detail', "POST", {}, true)
}
export function integralAddressEdit() {
	return sendHttp('/diandi_integral/address/edit', "POST", {}, true)
}
export function integralAddressAdd() {
	return sendHttp('/diandi_integral/address/add', "POST", {}, true)
}
export function integralCartAdd() {
	return sendHttp('/diandi_integral/cart/add', "POST", {}, true)
}
export function integralCartList() {
	return sendHttp('/diandi_integral/cart/list', "POST", {}, true)
}
export function integralCartClear() {
	return sendHttp('/diandi_integral/cart/clear', "POST", {}, true)
}
export function integralCartDeletecart() {
	return sendHttp('/diandi_integral/cart/deletecart', "POST", {}, true)
}
