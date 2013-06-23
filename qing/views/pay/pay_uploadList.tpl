<h3 id="pos">照片瀑布</h3>
<div class="waterfall">
        {$allImageHtml}
</div>        
<div class="loading" id="loading">加载中...</div>
<div class="loading" id="nomoreresults">没有更多图片</div>  

<script type="text/javascript" src="/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="/js/scrollpagination.js"></script>
<link type="text/css" rel="stylesheet" href="/assets/css/waterfall.css"/>
<script type="text/javascript">
        $(document).ready(function(){
                jsManager.loadWaterFall();
                jsManager.loadScrollPagination();
        })
        
        var jsManager ={
                loadWaterFall:function(){
                        $('.waterfall').masonry({  
                            columnWidth: 245 
                        });      
                },
                loadScrollPagination:function(){
//                        lastUpdatedTime = $("div.waterfall div:last-child").children("input.updatedTime").val();
                        $('.waterfall').scrollPagination({
                                'contentPage': 'index.php?r=pay/getMoreUploadList/', // the url you are fetching the results
                                'contentData': { lastupdatedtime:function(){ return $("div.waterfall div:last-child").children("input.updatedTime").val()}}, // these are the variables you can pass to the request, for example: children().size() to know which page you are
                                'scrollTarget': $(window), // who gonna scroll? in this example, the full window
                                'heightOffset': 1, // it gonna request when scroll is 10 pixels before the page ends
                                'beforeLoad': function(){ // before load function, you can display a preloader div
                                        $('#loading').fadeIn();	
                                },
                                'afterLoad': function(elementsLoaded){ // after loading content, you can use this function to animate your new elements
                                         if(!$(elementsLoaded).size()){
                                                $('#loading').html("没有更多图片");
                                                return;                                         
                                         }
                                         $('#loading').fadeOut();
                                         $(elementsLoaded).fadeInWithDelay();
                                         if ($('.waterfall').children().size() > 100){ // if more than 100 results already loaded, then stop pagination (only for testing)
                                                $('#nomoreresults').fadeIn();
                                                $('.waterfall').stopScrollPagination();
                                         }
                                }
                        });
                        $.fn.fadeInWithDelay = function(){
                                var delay = 0;
                                this.each(function(){
                                        $(".waterfall").masonry("appended",this);//scrollpagination中结合masonry自动加载瀑布
                                        delay += 100;
                                });
                        };                         
                }
        }
</script>