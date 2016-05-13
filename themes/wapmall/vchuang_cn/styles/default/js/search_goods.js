$(function(){

    /* 筛选事件 */
    $("a[data_obj='brand']").bind('click', function(){
        replaceParam('brand', this.id);
        return false;
    });
	$("a[data_obj='region_id']").bind('click', function(){
        replaceParam('region_id', this.id);
        return false;
    });
    $("div[data_obj='cate_id'] a").bind('click', function(){
        replaceParam('cate_id', this.id);
        return false;
    });

    $("a[data_obj='order_by']").bind('click', function(){
        replaceParam('order', this.id);
        return false;
    });

});
/* 转化JS跳转中的 ＆ */
function transform_char(str)
{
    if(str.indexOf('&'))
    {
        str = str.replace(/&/g, "%26");
    }
    return str;
}

/* 替换参数 */
function replaceParam(key, value)
{
    var params = location.search.substr(1).split('&');
	
    var found  = false;
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr   = param.split('=');
        pKey  = arr[0];
        if (pKey == 'page')
        {
            params[i] = 'page=1';
        }
        if (pKey == key)
        {
            params[i] = key + '=' + value;
            found = true;
        }
    }
    if (!found)
    {
        value = transform_char(value);
        params.push(key + '=' + value);
    }

    location.assign(WAP_URL + '/index.php?' + params.join('&'));
}

/* 删除参数 */
function dropParam(key)
{
    var params = location.search.substr(1).split('&');
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr   = param.split('=');
        pKey  = arr[0];
        if (pKey == 'page')
        {
            params[i] = 'page=1';
        }
        if (pKey == key)
        {
            params.splice(i, 1);
        }
    }
    location.assign(WAP_URL + '/index.php?' + params.join('&'));
}
