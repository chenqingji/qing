/**
 * 排序
 */
function sortByKey(sortform,sortKey,sortType){
	var action = getFormAction(sortform);	
	if(!action){
		alert("form不存在或者action未配置")
		return;
	}
	location.href=action+"/sortkey/"+sortKey+"/sorttype/"+sortType;
}
/**
 * 转到页面
 */
function go2Page(pageform,pageno){
	var action = getFormAction(pageform);	
	if(!action){
		alert("form不存在或者action未配置")
		return;
	}
	location.href=action+"/pageno/"+pageno;
}
function getFormAction(formId){
	return $("#"+formId).attr("action")
}

/**
 * 全选按钮事件
 */
var checkAll = function() {
	var all_checked = false;
	var enabledChkMeJQ = this.wrapper.find(".chkMe:checkbox:enabled");
	if (enabledChkMeJQ.size() == enabledChkMeJQ.filter(":checked").size()) {
		all_checked = true;
	}
	if (all_checked) {
		this.checked = false;
		this.wrapper.find(".chkMe:checkbox").each(function() {
			this.checked = false;
		});
	} else {
		this.checked = true;
		enabledChkMeJQ.each(function() {
			this.checked = true;
		});
	}
}
/**
 * 选项选择事件
 */
var checkMe = function() {
	var chkAllJQ = this.wrapper.find(".chkAll:checkbox:enabled");
	if (!this.checked) {
		chkAllJQ.each(function() {
			this.checked = false;
		});
	} else {
		var all_checked = false;
		var enabledChkMeJQ = this.wrapper.find(".chkMe:checkbox:enabled");
		if (enabledChkMeJQ.size() == enabledChkMeJQ.filter(":checked").size()) {
			all_checked = true;
		}
		if (all_checked) {
			chkAllJQ.each(function() {
				this.checked = true;
			});
		}
	}
}

/**
 * jQuery 功能扩展.
 */
jQuery.fn.extend({
	/**
	 * checkMe 和 checkAll 合起来可以做出一个全部选择的 checkbox
	 * 每个被控制的 checkbox 应该有如下形式：
	 * <input type="checkbox" class="chkMe" />
	 * <input type="checkbox" class="chkAll" />
	 *
	 * 并在页面转载完成后调用此函数：
	 * jQuery(function() {
	 *    jQuery("#checkTable").exCheckAll(true);
	 * });
	 */
	exCheckAll: function() {
		var wrapperObject = jQuery(this);
		var cheAllObject = jQuery(this).find(".chkAll:checkbox");
		cheAllObject.each(function() {
			this.wrapper = wrapperObject;
			this.onclick = checkAll;
		});
		jQuery(this).find(".chkMe:checkbox").each(function() {
			this.wrapper = wrapperObject;
			this.onclick = checkMe;
		});
		cheAllObject.filter(":checked").click();
		return jQuery(this);
	},
	/**
	 * 获取选中的个数
	 */
	getCheckedSize: function(){
		return jQuery(this).find(".chkMe:checked:checked").size();
	},
	/**
	 * 获取选项总数
	 */
	getTotalSize:function(){
		return jQuery(this).find(".chkMe:checkbox").size();
	}
});
	

/**
 * 中文验证
 * @param str
 * @returns {Boolean}
 */
function containChinese(str){
	var reg = new RegExp("[\\u4e00-\\u9fa5]", "");
    return reg.test(str);
}
