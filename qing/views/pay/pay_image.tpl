{if $images}
{foreach from=$images item=one}        
          <div class="water-item">
                <input type="hidden" class="updatedTime" value="{$one.updatedTime}"/>
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