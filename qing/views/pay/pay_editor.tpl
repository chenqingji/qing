<h3 id='pos'>编辑器</h3>
<form name="list_form" action="" method="post"/>
        <script type="text/plain" id="myEditor" name="myEditor"></script>
        <!--<textarea id='myEditor' name="myEditor"></textarea>-->
</form>

<div><input type='button' name='not' value ="发表" onclick="issue();" /></div>
<script type="text/javascript" src="/js/ueditor/editor_config.js"></script>                 
<script type="text/javascript" src="/js/ueditor/editor_all_min.js"></script>                 
<script type="text/javascript">
        var editor;
        $(document).ready(function(){
                editor = UE.getEditor('myEditor');
        });
        function issue(){
                var content = editor.getContent();
//                var content = editor.getAllHtml();
                $.ajax({
                        type:'post',
                        url:'index.php?r=pay/issue',
                        data:{ 'content':content},
                        beforeSend:function(){
                                var tips = "<em class='warn'>正在发表，请稍候</em>";
                                $("#main div.in").prepend(tips);                                
                        },
                        success:function(msg){
//                                console.log(msg);
                                if(msg){
                                        var tips = "<em class='valid'>发表成功</em>";
                                        $("em").remove(".warn");
                                        $("#main div.in").prepend(tips);                                
                                }else{
                                        this.error();
                                }
                        },
                        error:function(){
                                var tips = "<em class='wrong'>发表失败</em>";
                                $("em").remove(".warn");
                                $("#main div.in").prepend(tips);                        
                        },
                        complete:function(){
                        }                        
                });
        }
</script>

