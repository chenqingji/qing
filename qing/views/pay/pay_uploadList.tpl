<h3 id="pos">照片瀑布</h3>
<div class="waterfall">
        {if $images}
        {foreach from=$images item=one}        
                  <div class="water-item">
                        <div class="water-item-bg">
                        <i class="tagIcon"></i>                        
                        <div class="pic">
                                <a target="_blank" href="/upload/{$one.createdTime|date_format:'%Y/%m/%d'}/{$one.name}">
                                <img style="width:100%;" src="/upload/{$one.createdTime|date_format:'%Y/%m/%d'}/thumb_{$one.name}">
                                </a>
                        </div>
                        <h3 class="title">{$one.note|default:'这家伙很懒没有写描述~~'}</h3>
                        <div class="share"><a href="">chenqingji</a>分享</div>
                        <div class="recommend">
                                <em><a href="javascript:void(0);">推荐</a>&nbsp;&nbsp;-&nbsp;&nbsp;</em>
                                <a href="javascript:void(0);">回复</a>
                        </div>
                        </div>
                  </div>
        {/foreach}
        {/if}
</div>        
<script type="text/javascript" src="/js/masonry.pkgd.min.js"></script>
<link type="text/css" rel="stylesheet" href="/assets/css/waterfall.css"/>
<script type="text/javascript">
        $(document).ready(function(){
                $('.waterfall').masonry({  
                  columnWidth: 245 
//                  singleMode: false,  
//                  // 禁用测量每个浮动元素的宽度。  
//                  // 如果浮动元素具有相同的宽度，设置为true。  
//                  // 默认： false  
//
//                  columnWidth: 240,  
//                  // 1列网格的宽度，单位为像素（px）。  
//                  // 默认： 第一个浮动元素外宽度。  
//
//                  itemSelector: '.box:visible',  
//                  // 附加选择器，用来指定哪些元素包裹的元素会重新排列。  
//
//                  resizeable: true,  
//                  // 绑定一个 Masonry 访问 用来 窗口 resize时布局平滑流动.  
//                  // 默认：true  
//
//                  animate: true,  
//                  // 布局重排动画。  
//                  // 默认：false  
//
//                  animationOptions: { },  
//                  // 一对动画选项，具体参数可以参考jquery .animate()中的options选项  
//
//                  appendedContent: $('.new_content'),  
//                  //  附加选择器元素，用来尾部追加内容。  
//                  // 在集成infinitescroll插件的情况下使用。  
//
//                  saveOptions: true
//                  // 默认情况下，Masonry 将使用以前Masonry使用过的参数选项,所以你只需要输入一次选项  
//                  // 默认：true  
//
//                },  function() { }  
                  // 可选择的回调函数  
                  // 'this'将指向重排的Masonry适用元素  
                });          
 
        })
</script>