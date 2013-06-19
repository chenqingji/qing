<h3 id="pos">{$issue.title|default:'EMPTY TITLE'}</h3>
<div>
        {$issue.content}
</div>
<link href="/js/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/js/ueditor/third-party/SyntaxHighlighter/shCore.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
                SyntaxHighlighter.all();//需要语法高亮显示
        });

</script>