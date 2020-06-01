$(document).ready(function(){

    $(document).on('click', '.catalog-right__bottom-link', function(){
        var elements ='';
        var pagination='';
        var paginationTop='';
        var $preloader = $('.preloader');
        var targetContainer = $('.catalog-right_block'),          //  Контейнер, в котором хранятся элементы
            url =  $('.catalog-right__bottom-link').attr('data-url');    //  URL, из которого будем брать элементы

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                beforeSend: function() {
                    $preloader.show();
                },
                success: function(data){
                    $('.catalog-right_block').next('.pagination_search').remove();
                    $('.pagination__top').find('.pagination__bottom').remove();
                    //  Удаляем старую навигацию

                    elements = $(data).find('.catalog-right_block .product-box');  //  Ищем элементы
                    pagination = $(data).find('.catalog-right_block').next('.pagination_search');
                    paginationTop = $(data).find('.pagination__top');
                    targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                    targetContainer.after(pagination); //  добавляем навигацию следом
                    $('.catalog-right .pagination__top').after(paginationTop); //  добавляем навигацию следом
                },
                complete: function(){
                    $preloader.hide();
                }
            })
        }

    });

});

