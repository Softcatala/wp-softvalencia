jQuery.noConflict();
(function($){
    $(document).ready(function(){
        if($("a.tab")) {
            // When a link is clicked
            $("a.tab").click(function () {

                // switch all tabs off
                $(".active").removeClass("active");

                // switch this tab on
                $(this).addClass("active");

                // slide all elements with the class 'content' up
                $(".content").slideUp();

                // Now figure out what the 'title' attribute value is and find the element with that id.  Then slide that down.
                var content_show = $(this).attr("title");
                $("#"+content_show).slideDown();

            });
        }


        $('#s5').cycle({
            fx:    'fade',
            pause:  1,
            timeout: 6000
        });

    });

    var num = 3;
    var current = 1;
    var actual = 0;

    function slide()
    {
        if($("#slide"+current)) {
            $("#slide" + current).hide();
            current = (current >= num) ? 1 : current + 1;
            $("#slide" + current).fadeIn(3000);
        }

    }

    function desplega(nav)
    {
        var opcions=new Array("nav1","nav2","nav3","nav4","nav5","nav6","nav7");

        for (y=0; y<7; y++)
        {

            if (opcions[y] != nav)
                $("#" + opcions[y]).hide();
        }


        $("#" + nav).fadeIn(3000);

    }

    document.softvalencia = {};
    document.softvalencia.slide = slide;
    document.softvalencia.desplega = desplega;

})(jQuery);
