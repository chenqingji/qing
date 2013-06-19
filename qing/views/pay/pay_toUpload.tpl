<h3 id='pos'>上传文件</h3>
<form name="form1" action="index.php?r=pay/addFile" method="post">
<p style="margin-bottom: 10px;margin-left: 40px;"><input type="file" name="uploadInput" id="uploadInput" /></p>
<div id='someFileQueue'></div>
<p style="margin-bottom: 10px"><label>描述：</label><input type="text" id="note" name="note" value="" style="width:300px;" /></p>
</form>
<button id="submitBtn" name="submitBtn" disabled="disabled">确定</button>&nbsp;&nbsp;<em class="note">*请先上传文件</em>

<link href="/js/uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/uploadify/jquery.uploadify.min.js"></script>
<script type=text/javascript>
        $(document).ready(function(){
                $("#submitBtn").bind('click', function(){
                        document.form1.submit();
                });
                $("#uploadInput").uploadify({
                        //option
//                        auto:false,
                        formData:{ 'PHPSESSID':'{$sessionId}','name':''},
                        uploader:'index.php?r=upload/payUpload',
                        swf:'/js/uploadify/uploadify.swf',
                        buttonText:'上传文件',
                        buttonImage:'/js/uploadify/uploadify-btn.png',
                        height:78,
                        width:230,
                        fileSizeLimit:10 * 1024,//默认单位为KB
                        fileTypeExts:'*.gif;*.jpg;*.png',//默认*.*
                        method:'post',//采用get或post 默认post
                        multi:true,//是否支持多文件上传 默认true
                        progressData:'percentage',//上传时显示的数据，上传速度或百分比 speed percentage
                        queueID:"someFileQueue",//用于指定上传队列显示的位置 可以不设置默认在上传空间下方显示
                        removeCompleted:false,//上传完成是否删除队列中的对应元素，默认true
//                        removeTimeout:3,//上传完成后多久删除队列中的进度 ，默认3秒
                        uploadLimit:50,//最多上传文件数量，默认99
                        //event
                        onCancel:function(file){
                                if(confirm('确定取消文件'+file.name+'上传？')){
                                        return true;
                                }else{
                                        return false;
                                }
                        },
                        onUploadStart:function(file){
                                $("#uploadInput").uploadify('settings','name',file.name);//可替换formData中的参数
                                $("em.note").html("*请等待文件上传完成");
                        },
                        onUploadSuccess:function(file,data,response){
                                var dataJson = JSON.parse(data);
//                                console.log(dataJson);
                                $("#uploadInput").after('<input type="hidden" name="files[]" value="'+dataJson.name+'"/>');
                                $("#submitBtn").attr("disabled", false);
                                $("em.note").html("*请点击确定提交");
//                                console.log(file);
//                                console.log(data);
//                                console.log(response);
                        },
                        onFallBack:function(){
                                alter('Flash was not detected.');
                        }
                        
                        
                });
        });
</script>