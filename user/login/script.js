$(document).ready(function(){
    $("#register").on("click", function(){
        $("input").val('');
        $("#container").addClass("active");
    });

    $("#login").on("click", function(){
        $("input").val('');
        $("#container").removeClass("active");
    });

    $("#register2").on("click", function(){
        $("input").val('');
        $("#container").addClass("active2");
    });

    $("#login2").on("click", function(){
        $("input").val('');
        $("#container").removeClass("active2");
    });

    $("#forget").on("click", function(){
        $("input").val('');
        $("#container").addClass("forget");
    })

    $("#update").on("click", function(){
        $("#container").removeClass("forget");
    })

    // $("#signin").on("click", function(){
    //     $("input").val('');
    // })
});

