$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");  },
     ajaxStop: function() { $body.removeClass("loading"); $('#footer').fadeIn(); }    
});

function createNewsList(key, news) {
    var template = [
    "<li id='key_",key,"' class='lead list-group-item shadow-sm p-2 mb-3 bg-white rounded'>",
    "<p ><a href='",news.url,"' target='_blank' class='text-dark'><span>",news.title || '',"</span> <i class='fas fa-external-link-alt ml-2'></i></a></p>",
    "<div class='d-flex justify-content-md-center flex-wrap'>",
        "<div class='p-2'><button type='button' class='btn btn-light-outline'>",
        "<i class='far fa-user'></i>",
        "<span class='badge badge-light'>",news.by || '',"</span></button></div>",
        "<div class='p-2'><a role='button' class='btn btn-light-outline' href='/discussion/",news.id,"'>",
        "<i class='far fa-comments'></i>",
        "<span class='badge badge-light'>",news.descendants || 0,"</span></a></div>",
        "<div class='p-2'><button type='button' class='btn btn-light-outline'>",
        "<i class='far fa-thumbs-up'></i>",
        "<span class='badge badge-light'>",news.score || 0,"</span></button></div>",
        "<div class='p-2 ml-md-auto'><button type='button' class='btn btn-light-outline'>",
        "<span class='badge badge-light-outline'>Posted: ", utcToTimeAgo(news.time) || '',"</span></button></div>",
        "</div>",
    "</div>",  
    "</li>"];

    return $(template.join(''));
}

function utcToTimeAgo(ts) {
    // This function computes the delta between the
    // provided timestamp and the current time, then test
    // the delta for predefined ranges.

    var d=new Date();  // Gets the current time
    var nowTs = Math.floor(d.getTime()/1000); // getTime() returns milliseconds, and we need seconds, hence the Math.floor and division by 1000
    var seconds = nowTs-ts;

    // more that two days
    if (seconds > 2*24*3600) {
       return "a few days ago";
    }
    // a day
    if (seconds > 24*3600) {
       return "yesterday";
    }

    if (seconds > 3600) {
       return "a few hours ago";
    }
    if (seconds > 1800) {
       return "Half an hour ago";
    }
    if (seconds > 60) {
       return Math.floor(seconds/60) + " minutes ago";
    }
}
$(document).ready(function() {
if($("body").hasClass("news")) {
    var total;
    $.ajax({ 
        url: '/topstories/0/25',
        success: function(data) {
            var listItems = $();
            data.forEach(function(item, i) {
                listItems = listItems.add(createNewsList(i, item));
              });
            
            $( "<ul/>", {
                "class": "list-group list-group-flush",
                "id": "news",
                html: listItems
            }).appendTo( "div.news" );

            $('<button />', {
                "class": "btn btn-primary clearfix load-more ml-auto",
                html: "More..." 
            }).appendTo('div.news');
            
            total = document.querySelectorAll('.list-group-item').length;
        }
    });


    $(document).on('click', 'button.load-more',function() {

        
        var stop = total + 25;
        var url = '/topstories/'+total+'/'+stop;
        $.ajax({ 
            url: url,
            success: function(data) {
                var listItems = $();
                data.forEach(function(item, i) {
                    listItems = listItems.add(createNewsList(i, item));
                  });
                $('ul#news').append(listItems);
                
                total = stop;
            }
        });

    });
});
