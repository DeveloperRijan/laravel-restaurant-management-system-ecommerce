$(document).ready(function(){
    //pagination only
    $(document).on('click', '.pagination li a', function(e){
        e.preventDefault()
        let action_url = $("#hidden__action_url").val()
        let pageNumber = $(this).attr('href').split('page=')[1]
        let searchKey = $("#searchKey__").val()
        $("#hidden__page_number").val(pageNumber)
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })
    //live search with pagination
    $(document).on("keyup", "#searchKey__", function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $(this).val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    //dynamic sorting management is ajax
    $(".sortAble").on("click", function(){
        let action_url = $("#hidden__action_url").val()
        let sortingColumn = $(this).attr('sorting-column')
        let sort_order = $(this).attr('sorting-order')


        let setSortingOrder = "";
        let sortICON = "";
        if (sort_order == '') {
            setSortingOrder = 'DESC';
            sortICON = ('<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"/> <path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8 3.707 5.354 6.354a.5.5 0 1 1-.708-.708l3-3z"/> </svg> ')
        }else if (sort_order == "DESC") {
            setSortingOrder = 'ASC';
            sortICON = ('<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M4.646 9.646a.5.5 0 0 1 .708 0L8 12.293l2.646-2.647a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"/> <path fill-rule="evenodd" d="M8 2.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V3a.5.5 0 0 1 .5-.5z"/> </svg> ')
        }else {
            setSortingOrder = 'DESC';
            sortICON = ('<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"/> <path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8 3.707 5.354 6.354a.5.5 0 1 1-.708-.708l3-3z"/> </svg> ') 
        }
        $("#hidden__sort_by").val(sortingColumn)
        $("#hidden__sorting_order").val(setSortingOrder)
        $('.sortAble').children("svg").remove();//remove
        $('.sortAble').attr("sorting-order", '');

        $(this).attr('sorting-order', setSortingOrder)
        $(this).prepend(sortICON)

        let searchKey = $("#searchKey__").val()
        let pageNumber = $("#hidden__page_number").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()

        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    //if change option of row per page
    $("#selected_row_per_page").on('change', function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $(this).val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    //if change option of row per page
    $("#hidden__id").on('change', function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $(this).val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    //if change option of row per page
    $("#hidden__status").on('change', function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $(this).val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    ///if change hidden sorting order
    $("#hidden__sorting_order").on('change', function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $(this).val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })
    
    //if change option
    $("#hidden_paramters__one").on("change", function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })
    
    //if change option
    $("#hidden_paramters__two").on("change", function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    //if change option
    $("#hidden_paramters__three").on("change", function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    //if change option
    $("#hidden_paramters__four").on("change", function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })

    //if change option
    $("#hidden_paramters__five").on("change", function(){
        let action_url = $("#hidden__action_url").val()
        let searchKey = $("#searchKey__").val()
        let pageNumber = 1;
        let sort_by = $("#hidden__sort_by").val()
        let sorting_order = $("#hidden__sorting_order").val()
        let hidden__status = $("#hidden__status").val()
        let row_per_page = $("#selected_row_per_page").val()
        let hidden__id = $("#hidden__id").val()
        
        let param_1 = $("#hidden_paramters__one").val()
        let param_2 = $("#hidden_paramters__two").val()
        let param_3 = $("#hidden_paramters__three").val()
        let param_4 = $("#hidden_paramters__four").val()
        let param_5 = $("#hidden_paramters__five").val()
        fetch_paginate_data(action_url, pageNumber, searchKey, sort_by, sorting_order, hidden__status, row_per_page, hidden__id, param_1, param_2, param_3, param_4, param_5);
    })
})



//fetch data
function fetch_paginate_data(action_url, pageNumber, searchKey, sortBy, sortingOrder, hidden__status, rowPerPage, hidden__id, param_1, param_2, param_3, param_4, param_5){
    $.ajax({
        url:action_url+"?page="+pageNumber+"&search_key="+searchKey+"&sort_by="+sortBy+"&sorting_order="+sortingOrder+"&status="+hidden__status+"&row_per_page="+rowPerPage+"&id="+hidden__id+"&param_1="+param_1+"&param_2="+param_2+"&param_3="+param_3+"&param_4="+param_4+"&param_5="+param_5,
        method:'GET',
        cache:false,
        success:function(response){
            $("#render__data").html(response)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 422) {
                alert('Sorry\n'+ jqXHR.responseText)
                //window.location.reload(true)
            }else if (jqXHR.status === 401) {
                alert('Sorry\n'+ jqXHR.responseText)
                //window.location.reload(true)
            }else{
                alert('Sorry\n Something unknown problem')
                //window.location.reload(true)
            }

        }
    })
}

