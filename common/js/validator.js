/**
 * 与yii配合的验证类
 * 
 */     
function Validator(cfg){
	this.errorEls={};
	this.validateErrors=[];
	this.init(cfg);
}
    
Validator.prototype={
	init:function(cfg){
		this.initErrors = cfg.initErrors||[];
		this.formEl = $(cfg.form);
		this.listeners = cfg.listeners||{};
		this.isShowFirstError = cfg.isShowFirstError||false;//是否只提示第一个错误
		this.isEachErrorShow = cfg.isEachErrorShow||false;//是否显示属性各自错误设置
		this.extRules = cfg.extRules||[];
		if(this.formEl.length!=1){
			throw "Error initializing form validator, only can specify one form";
		}
		this.rules = cfg.rules;
		this.errorSummaryContain = cfg.errorSummaryContain;
		this.showInitMessage(this.initErrors);
		this.bindValidateEvent();
	},
	/**
     * 获取表单要验证的属性
     */
	getAttributeNames:function(){
		var attributeNames=[];
		var elements=this.formEl[0].elements;
		for(var i=0,len=elements.length;i<len;i++){
			if(elements[i].name && !this.isInArray(elements[i].name,attributeNames)){
				attributeNames.push(elements[i].name);
			}
		}
		return attributeNames;
	},
	/**
     * 判断元素是否在数组里面
     */
	isInArray:function(value,arr){
		for(var i=0,len=arr.length;i<len;i++){
			if(value === arr[i]){
				return true;
			}
		}
		return false;  
	},
	/**
     * 表单验证事件
     */
	bindValidateEvent:function(){
		this.bindAttributeEvent();
		this.bindFormSubmit();
	},
	/**
     * 绑定表单提交事件的验证
     */
	bindFormSubmit:function(){
		var _this=this;
		this.formEl.bind("submit",function(){
			var messages=_this.checkAllError();
			if(messages.length>0){
				_this.showSummaryMessage(messages);
				return false;//取消提交
			}else{
				if(!_this.formEl[0]["__checkFormByClientStatus__"]){//设表单前端验证成功标志
					_this.formEl.append("<input name='__checkFormByClientStatus__' type='hidden' value='ok'>");
				}
			}
		}); 
	},
	/**
     * 绑定表单元素操作时候的验证
     */
	bindAttributeEvent:function(){
		if(this.isEachErrorShow){
		var attributeNames = this.getAttributeNames();
		for(var i=0,len=attributeNames.length;i<len;i++){
			var tag=this.getTag(attributeNames[i]);
			if(tag&&this.getClientValidation(attributeNames[i])){
				var _this=this;
				$(tag).bind("blur",{
					"attributeName":attributeNames[i]
				},function(e){
					_this.checkError(e.data["attributeName"],e.type);
				}).bind("keyup",{
					"attributeName":attributeNames[i]
				},function(e){
					if(e.keyCode!=13){
			        _this.clearErrorEl(e.data["attributeName"]);
		            }
				});
			}
		}
	}
	},
	/**
     * 显示初始化的错误提示信息
     */
	showInitMessage:function(messages){
		this.showSummaryMessage(messages);
		for(var i=0,len=messages.length;i<len;i++){
			this.showMessage(messages[i]["attributeName"],messages[i]["errors"]);
		}
	},
	/**
     * 表单提交时候的错误总汇
     */
	showSummaryMessage:function(messages){
		var messagesStr="";
		if(messages.length==0){
			return ;
		}
		if(this.errorSummaryContain!==null){
			if(this.errorSummaryContain&&this.errorSummaryContain.length>0){
				for(var i=0,len=messages.length;i<len;i++){
					if(messages[i]["errors"]){
						messagesStr+="<p>"+messages[i]["errors"].join("</p><p>")+"</p>";
					}
				}
				this.errorSummaryContain.html(messagesStr);
				this.focusAttribute(messages[0]["attributeName"]);
			}else{
				var _this=this;
				alert(messages[0]["errors"][0],function(){
					_this.focusAttribute(messages[0]["attributeName"]);
				});
			}
		}else{
			this.focusAttribute(messages[0]["attributeName"]);
		}
	},
	/**
     * 显示表单单个属性的验证信息
     */
	showMessage:function(attributeName,message){
		if(this.isEachErrorShow){
			if(message.length>0){
				var errorEl=this.getErrorEl(attributeName);
				if(errorEl){
					errorEl.html(message.join(" "));
				}
			}
		}
	},
	/**
	 * 聚焦表单元素
	 */
	focusAttribute:function(attributeName){
		var focusTag=this.getTag(attributeName);
		if(focusTag&&!($(focusTag).is(":hidden"))&&focusTag.focus){
			focusTag.focus();
		}
	},
	/**
     * 获取显示验证的错误信的jquery对象
     */
	getErrorEl:function(attributeName){
		var  extRule=this.getExtRule(attributeName);
		if(extRule&&extRule["errorContain"]===null){
			return null;
		}
		if(extRule&&extRule["errorContain"]&&extRule["errorContain"].length>0){
			return extRule["errorContain"];
		}
		if(this.errorEls[attributeName]){
			return this.errorEls[attributeName];
		}else{
			var	errorContain=$("<span class='col_text'></span>");
			$(this.getTag(attributeName)).after(errorContain);
			this.errorEls[attributeName]=errorContain;
			return errorContain;
		}
	},
	
	clearErrorEl:function(attributeName){
		var errorEl=this.getErrorEl(attributeName);
		if(errorEl){
			errorEl.html("");
		}
	},
	/**
     * 由表单模型属性名获取表单的html标签
     */
	getTag:function(attributeName){
		return this.formEl[0][attributeName]||null;
	},
	/**
    * 获取某个表单属性的验证规则
    */
	getClientValidation:function(attributeName){
		for(var i=0,len=this.rules.length;i<len;i++){
			if(this.rules[i]["name"]==attributeName){
				return this.rules[i]["clientValidation"];
			}
		}
		return null;
	},
	getExtRule:function(attributeName){
		for(var i=0,len=this.extRules.length;i<len;i++){
			if(this.extRules[i]["name"]==attributeName){
				return this.extRules[i];
			}
		}
		return null;
	},
	/**
     * 验证某个表单模型属性
     */
	checkError:function(attributeName,eventType){
		eventType=eventType||"";
		var message=[];
		var tag=this.getTag(attributeName);
		var clientValidation=this.getClientValidation(attributeName);
		if(clientValidation){
			clientValidation(tag.value,message,attributeName,{
				"validator":this
			});
		}
		var msg=message.length>0?[message[0]]:[];//只返回第一个错误，避免显示太多的错误信息，造成页面不简洁
		this.showMessage(attributeName,msg);
		return  msg;
	},
	/**
     * 验证整个表单
     */
	checkAllError:function(){
		var attributeNames= this.getAttributeNames();
		var messages=[];
		this.validateErrors=[];//清空错误
		if(this.listeners.beforeValidate){
			this.listeners.beforeValidate.call(this,this);
		}
		for(var i=0,len=this.validateErrors.length;i<len;i++){
			messages.push({
				'attributeName':this.validateErrors[i]["attributeName"],
				'errors':this.validateErrors[i]["errors"]
			}); 
		}
		for(var i=0,len=attributeNames.length;i<len;i++){
			var errors=this.checkError(attributeNames[i]);
			if(errors&&errors.length>0){
				messages.push({
					'attributeName':attributeNames[i],
					'errors':errors
				}); 
			}
		}
		this.validateErrors=[];//清空错误
		if(this.listeners.afterValidate){
			this.listeners.afterValidate.call(this,this);
		}
		for(var i=0,len=this.validateErrors.length;i<len;i++){
			messages.push({
				'attributeName':this.validateErrors[i]["attributeName"],
				'errors':this.validateErrors[i]["errors"]
			}); 
		}
		if(this.isShowFirstError&&messages.length>1){
			return [messages[0]];
		}
		return messages;
	},
	addError:function(attributeName,error){
		this.validateErrors.push({
			'attributeName':attributeName,
			'errors':[error]
		});
	}
};