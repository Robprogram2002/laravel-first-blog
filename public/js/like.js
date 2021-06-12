var url = "http://localhost/practice%20php/aprendiendo%20php/blog/public";
window.addEventListener("load", function() {
    $(".btn-like").css("cursor", "pointer");
    $(".btn-dislike").css("cursor", "pointer");

    //boton de like
    function like() {
        $(".btn-like")
            .unbind("click")
            .click(function() {
                console.log("like");
                $(this)
                    .addClass("btn-dislike")
                    .removeClass("btn-like");
                $(this).attr(
                    "src",
                    "http://localhost/practice%20php/aprendiendo%20php/blog/public/icons/like-red.png"
                );

                var id = $(this).data('id');

                $.ajax({
                    url: `${url}/like/${$(this).data("id")}`,
                    type: "GET",
                    success: function(response) {
                        console.log(response);
                        var numberlikes = response["numberlikes"];
                        $('.number-likes[data-id='+id+']').html(numberlikes);
                    }
                });

                dislike();
            });
    }
    like();

    //boton de dislike
    function dislike() {
        $(".btn-dislike")
            .unbind("click")
            .click(function() {
                $(this)
                    .addClass("btn-like")
                    .removeClass("btn-dislike");
                $(this).attr(
                    "src",
                    "http://localhost/practice%20php/aprendiendo%20php/blog/public/icons/favorite-64.png"
                );

                var id = $(this).data('id');

                $.ajax({
                    url: `${url}/dislike/${$(this).data("id")}`,
                    type: "GET",
                    success: function(response) {
                        console.log(response);
                        var numberlikes = response["numberlikes"];
                        $('.number-likes[data-id='+id+']').html(numberlikes);
                    }
                });

                like();
            });
    }
    dislike();
});
