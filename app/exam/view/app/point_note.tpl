{x2;tree:$notes['data'],note,nid}
<div class="pagebox notes">
    <h4 style="font-size: 18px;font-weight: 800;color:#02756E;">用户:{x2;v:note['noteusername']}</h4>
    <p>{x2;v:note['notecontent']}</p>
</div>
{x2;endtree}
{x2;if:$notes['pages']}
<ul class="pagination pull-right">
    {x2;$notes['pages']}
</ul>
{x2;endif}