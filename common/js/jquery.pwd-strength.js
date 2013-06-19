(function($) {
	$.fn.strength_validate = function(options) {
		return this.each(function() {
			var obj = $(this);
			obj.data("_password_strength_options",$.extend({}, $.fn.strength_validate.defaults, options));
			obj.keyup(function(){
				$.fn.strength_validate.validate(this);
			}); 
			obj.blur(function(){
				$.fn.strength_validate.validate(this);
			}); 
		});
    }; 

    $.fn.strength_validate.defaults = { 
		'common': "ccommon",
		'val': 1,
		'lang':"zh",
        'check_weak': true,
        'weak_password' :new Array('abc123','123abc','abc+123','test123','temp123','mypc123','admin123'),
        'check_string_a_z':"abcdefghijklmnopqrstuvwxyz zyxwvutsrqponmlkjihgfedcba",
        'check_string_keybord':"1234567890 qwertyuiop asdfghjkl; zxcvbnm,./ 1qaz 2wsx 3edc 4rfv 5tgb 6yhn 7ujm 8ik, 9ol. 0p;/ /;p0 .lo9 ,ki8 mju7 nhy6 bgt5 vfr4 cde3 xsw2 zaq1 /.,mnbvcxz ;lkjhgfdsa poiuytrewq 0987654321",	
        'week_msg':new Array('','密码太短','密码不能包含账号名称','您的密码在弱口令字典中','密码至少需要包含2种不同的字符类型','密码至少需要包含4个不同的字符','密码中按（a-z, z-a）顺序连续字符串长度不能超出总长度的45%','密码中按键盘相邻顺序连续字符串长度不能超出总长度的45%'),
        'week_msg_tw':new Array('','密碼太短','密碼不能包含帳號名稱','您的密碼在弱口令字典中','密碼至少需要包含2種不同的字元類型','密碼至少需要包含4個不同的字元','密碼中按（a-z, z-a）順序連續字串長度不能超出總長度的45%','密碼中按鍵盤相鄰順序連續字串長度不能超出總長度的45%'),
        'week_msg_en':new Array('','Password is too short.','Password cannot contain the account name.','The password is in the weak password dictionary.','Password must contain more than 1 character types.','Password must contain more than 3 different characters.','Length of the longest (a-z, z-a) sequence should not exceed 45% of the total length.','Length of the longest adjacent keyboard sequence should not exceed 45% of the total length.'),
        'week_msg_zh_en':new Array('','密码太短(Password is too short.)','密码不能包含账号名称(Password cannot contain the account name.)','您的密码在弱口令字典中(The password is in the weak password dictionary.)','密码至少需要包含2种不同的字符类型(Password must contain more than 1 character types.)','密码至少需要包含4个不同的字符(Password must contain more than 3 different characters.)','密码中按（a-z, z-a）顺序连续字符串长度不能超出总长度的45%(Length of the longest (a-z, z-a) sequence should not exceed 45% of the total length.)','密码中按键盘相邻顺序连续字符串长度不能超出总长度的45%(Length of the longest adjacent keyboard sequence should not exceed 45% of the total length.)')
    }; 

	$.fn.strength_validate.validate = function(obj) {
		if($(obj).length==0){ return;}
		var opts=$(obj).data("_password_strength_options");
		var weakPasswordCheck=3;
		var lengthCheck=3;
		var kindsCheck=3;
		var commonCheck=1;//opt.common
		var difWordNumCheck=3;
		var a2zCheck=3;
		var keybordCheck=3;
		var weekObjCheck=1;//opt.weak_password_obj
		var password = $(obj).val();
		var common_val="";
		//存在密码
		if(password){
			if(opts.val){			
			var tmp_obj = $('.' + opts.common);
				if (tmp_obj.length > 0) {
					if (opts.val == 1) {
					common_val = tmp_obj.val();
					}
					else {
					common_val = tmp_obj.html();
					}
				}
				else {
					common_val = opts.val;
				}
				if (common_val && (password.indexOf(common_val)!=-1||password.indexOf(common_val.split('@')[0])!=-1)) { 
					commonCheck = 3; 
				}
	          }
		    
		    if(opts.weak_password_obj){//
	            var w_p =$(opts.weak_password_obj).val();
	            var mail_domain=opts.mail_domain||"";
	            if(password==w_p||password==(w_p+mail_domain)){
	            	weekObjCheck = 3;
	            }
	         }
			if(opts.weak_password){
             weakPasswordCheck=checkWeakPassword(password,opts.weak_password);//弱字典
			}
			lengthCheck=checkLength(password);//长度
			kindsCheck=checkKinds(password);//字符种类
			difWordNumCheck=checkDifWordNum(password);//不相同字符数
			a2zCheck=checkKeybord(password,opts.check_string_a_z)//a-z
			keybordCheck=checkKeybord(password,opts.check_string_keybord);//键盘输入规则
		}
		var checkStr=""+lengthCheck+weekObjCheck+commonCheck+weakPasswordCheck+kindsCheck+difWordNumCheck+a2zCheck+keybordCheck;
		deal_result(checkStr);
		week_msg_show(checkStr,opts);
		$(obj).data('pwdstrength', getStrongValue(checkStr));
	}
  
	function getStrongValue(checkStr){
		if (checkStr.indexOf("3") != -1) {
			return 1;//弱
		}else if(checkStr.indexOf("2") != -1) {
			return 2;//中
		}else{
			return 3;//强
		}
	}
	

	//判断密码是否包含在弱密码字典里，如果有返回3，如果没有返回1 
	function checkWeakPassword(password,weakpassword) {
		var has = 1;
		for ( var i = 0; i < weakpassword.length; i++) {
			if (password == weakpassword[i]) {
				has = 3;
				break;
			}
		}
		return has;
	}
	//判断密码长度符合哪个等级，返回符合的等级标志1：强密码 2：中等强度 3：弱密码 
	function checkLength(password) {
		if (password.length >= 8) {
			return 1;
		} else if (password.length >= 6) {
			return 2;
		} else {
			return 3;
		}
	}

	//获取密码中包含的字符种类，返回符合的等级标志1：强密码 2：中等强度 3：弱密码 
	function checkKinds(password) {
		var kinds = 0;
		if (password.match(/[a-z]+/)) {
			kinds = kinds + 1;
		}
		if (password.match(/[A-Z]+/)) {
			kinds = kinds + 1;
		}
		if (password.match(/[0-9]+/)) {
			kinds = kinds + 1;
		}
		if (password.match(/[\/,.~!@#$%^&*()\[\]_+\-=\:\";'\{\}\|\\><\?]+/)) {
			kinds = kinds + 1;
		}
		if (kinds >= 3) {
			return 1;
		} else if (kinds >= 2) {
			return 2;
		} else {
			return 3;
		}
	}


	//判断不同字符数符合的密码强度，返回符合的等级标志1：强密码 2：中等强度 3：弱密码 
	function checkDifWordNum(password) {
		var pwArray = password.split("");
		var count = 1;
		var temString = pwArray[0];
		for ( var i = 0; i < pwArray.length; i++) {
			if (temString.indexOf(pwArray[i]) != -1) {
				continue;
			} else {
				count = count + 1;
				temString = temString + pwArray[i];
			}
		}
		if (count >= 5) {
			return 1;
		} else if (count >= 4) {
			return 2;
		} else {
			return 3;
		}
	}

	// 检验密码对于连续字符和键盘矩阵符合哪个密码强度等级，返回符合的等级标志1：强密码 2：中等强度 3：弱密码 
	function checkKeybord(password,checkString) {
		var pwArray = password.split("");
		var strongLength = Math.floor((pwArray.length) * 30 / 100);
		var middleLength = Math.floor((pwArray.length) * 45 / 100);
		var subStr = "";
		var newPassword = replayShiftWord(password.toLowerCase());
		var level = 1;
		for ( var i = 0; i < newPassword.length - strongLength; i++) {
			subStr = newPassword.substring(i, i + strongLength+1);
			if (checkString.indexOf(subStr) == -1) {
				continue;
			} else {
				if ((i + middleLength) < newPassword.length && checkString.indexOf(newPassword.substring(i, i + middleLength+1)) != -1) {
						level = 3;
						break;
				}else {
					level = 2;
				}
			}
		}
		return level;
	}

	/** 对键盘按住shift后的字符进行替换 */
	function replayShiftWord(password) {
		return password.replace(/!/g, "1").replace(/@/g, "2").replace(/#/g, "3")
				.replace(/\$/g, "4").replace(/%/g, "5").replace(/\^/g, "6")
				.replace(/&/g, "7").replace(/\*/g, "8").replace(/\(/g, "9")
				.replace(/\)/g, "0").replace(/_/g, "-").replace(/\+/g, "=")
				.replace(/\|/g, "\\").replace(/\</g, ",").replace(/\>/g, ".")
				.replace(/\?/g, "/").replace(/\:/g, ";");
	}

	/**替换空格*/
	function trim(repString) {
		return repString.replace(/^\s\s*/,'').replace(/\s\s*$/,'');
	}
	
	function deal_result(checkStr)
	{
		var color_l = '#f00';
		var color_m = '#f90';
		var color_h = '#3c0';
		$(".strength").css('background', '#eee');
		if (checkStr.indexOf("3") != -1) {
			$(".strength").slice(0, 1).css('background', color_l);
		}else if(checkStr.indexOf("2") != -1) {
			$(".strength").slice(0, 2).css('background', color_m);
		}else{
			$(".strength").slice(0, 3).css('background', color_h);
		}
	}
	
	function week_msg_show(checkStr,opts){
		var checkArray=checkStr.split("");
		if ($("#week_pw_msg").length==0){
			$(".strength").slice(-1).after("<b id='week_pw_msg' style='color:#323232'></b>");
		}
		var week_pw_msg=$("#week_pw_msg");
		week_pw_msg.html("");
		var msg_index=0;
		if (checkArray[0]==3){
			msg_index=1;
		}else if (checkArray[1]==3||checkArray[2]==3){
			msg_index=2;
		}else if (checkArray[3]==3){
			msg_index=3;
		}else if (checkArray[4]==3){
			msg_index=4;
		}else if (checkArray[5]==3){
			msg_index=5;
		}else if (checkArray[6]==3){
			msg_index=6;
		}else if (checkArray[7]==3){
			msg_index=7;
		}
		if(opts.lang=='zh')
		{
			week_pw_msg.html('&nbsp;'+opts.week_msg[msg_index]);
		}else if(opts.lang=='tw')
		{
			week_pw_msg.html('&nbsp;'+opts.week_msg_tw[msg_index]);
		}else if(opts.lang=='en')
		{
			week_pw_msg.html('&nbsp;'+opts.week_msg_en[msg_index]);
		}
		else if(opts.lang=='zh_en')
		{
			week_pw_msg.html(opts.week_msg_zh_en[msg_index]);
		}
	}
})(jQuery);