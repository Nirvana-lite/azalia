BX.namespace("BX.Iblock.Catalog");

BX.Iblock.Catalog.CompareClass = (function()
{
	var CompareClass = function(wrapObjId, reloadUrl)
	{
		this.wrapObjId = wrapObjId;
		this.reloadUrl = reloadUrl;
		BX.addCustomEvent(window, 'onCatalogDeleteCompare', BX.proxy(this.reload, this));
	};

	CompareClass.prototype.MakeAjaxAction = function(url)
	{
		BX.showWait(BX(this.wrapObjId));
		BX.ajax.post(
			url,
			{
				ajax_action: 'Y'
			},
			BX.proxy(this.reloadResult, this)
		);
	};

	CompareClass.prototype.reload = function()
	{
		BX.showWait(BX(this.wrapObjId));
		BX.ajax.post(
			this.reloadUrl,
			{
				compare_result_reload: 'Y'
			},
			BX.proxy(this.reloadResult, this)
		);
	};

	CompareClass.prototype.reloadResult = function(result)
	{
		BX.closeWait();
		BX(this.wrapObjId).innerHTML = result;
	};

	CompareClass.prototype.delete = function(url)
	{
		BX.showWait(BX(this.wrapObjId));
		BX.ajax.post(
			url,
			{
				ajax_action: 'Y'
			},
			BX.proxy(this.deleteResult, this)
		);
	};

	CompareClass.prototype.deleteResult = function(result)
	{
		BX.closeWait();
		BX.onCustomEvent('OnCompareChange');
		BX(this.wrapObjId).innerHTML = result;
	};

	return CompareClass;
})();

/* Сравнение начало */
$(function () {

	var left = 0;
	var count = 0;
	var itemMinus = 4;
    var compareItem = $('.compare_product .product-box').length;
	if(compareItem > 4){
		$('.compare__wrapper__nav').css('display','block');
	}

	var ww = $(window).width();
	function header(ww) {
        var compareItem = $('.compare_product .product-box').length;
		if(ww < 1650 && ww> 1200){
			if(compareItem > 4){
                itemMinus = 3;
				$('.compare__wrapper__nav').css('display','block');
			}
		}
		else if(ww < 1200 && ww > 991){
			itemMinus = 3;
			$('.compare__wrapper__nav').css('display','block');
		}
		else if(ww < 991 && ww > 575){
			itemMinus = 2;
			$('.compare__wrapper__nav').css('display','block');
		}
		else if(ww < 575){
			itemMinus = 1;
			$('.compare__wrapper__nav').css('display','block');
		}else{
			itemMinus = 4;
		}
	}
	header(ww);

	$('.compare__wrapper__left').click(function () {
		count--;
		left = left + 24;
		$('.compare_product').css({"margin-left": left+"rem", "transition": "margin-left .2s linear"});
		$('.compare_ul').css({"margin-left": left+"rem", "transition": "margin-left .2s linear"});
		if(count <= 0){
			$('.compare__wrapper__left').css('display','none');
			$('.compare__wrapper__right').css('display','block');
		}else{
			$('.compare__wrapper__right').css('display','block');
		}
	});
	$('.compare__wrapper__right').click(function () {
		count++;
		left = left - 24;
		$('.compare_product').css({"margin-left": left+"rem", "transition": "margin-left .2s linear"});
		$('.compare_ul').css({"margin-left": left+"rem", "transition": "margin-left .2s linear"});
		if(count >= compareItem - itemMinus){
			$('.compare__wrapper__right').css('display','none');
			$('.compare__wrapper__left').css('display','block');
		}else{
			$('.compare__wrapper__left').css('display','block');
		}

	});
});

/* Сравнение конец */
$(window).resize(function () {
    var ww = $(window).width();
    function header(ww) {
        var compareItem = $('.compare_product .product-box').length;
        if(ww < 1650 && ww> 1200){
            if(compareItem > 4){
                itemMinus = 3;
                $('.compare__wrapper__nav').css('display','block');
            }
        }
        else if (ww < 1200 && ww > 991) {
            itemMinus = 3;
            $('.compare__wrapper__nav').css('display', 'block');
        }
        else if (ww < 991 && ww > 575) {
            itemMinus = 2;
            $('.compare__wrapper__nav').css('display', 'block');
        }
        else if (ww < 575) {
            itemMinus = 1;
            $('.compare__wrapper__nav').css('display', 'block');
        } else {
            itemMinus = 4;
            $('.compare__wrapper__nav').css('display', 'none');
        }
    }
    header(ww);
});