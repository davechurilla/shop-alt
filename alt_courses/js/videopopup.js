(function($) {

    $.fn.VideoPopUp = function(options) {

        var defaults = {
            backgroundColor: "#000000",
            opener: "video",
            maxweight: "640",
            pausevideo: false,
            idvideo: ""
        };

        var patter = this.attr('id');
        console.log(this.attr('id'));

        var settings = $.extend({}, defaults, options);

        var video = document.getElementById(settings.idvideo);

        function stopVideo() {
            video.pause();
            video.currentTime = 0;
        }

        $('#' + patter + '').css("display", "none");
        $('#' + patter + '').append('<div id="opct"></div>');
        $('#opct').css("background", "#17212a");
        $('#' + patter + '').css("z-index", "100001");
        $('#' + patter + '').css("position", "fixed")
        $('#' + patter + '').css("top", "0");
        $('#' + patter + '').css("bottom", "0");
        $('#' + patter + '').css("right", "0");
        $('#' + patter + '').css("left", "0");
        $('#' + patter + '').css("padding", "auto");
        $('#' + patter + '').css("text-align", "center");
        $('#' + patter + '').css("background", "none");
        $('#' + patter + '').css("vertical-align", "vertical-align");
        $("#videCont, #videCont02, #videCont03, #videCont04, #videCont05, #videCont06, #videCont07, #videCont08, #videCont09, #videCont10, #videCont11, #videCont12, #videCont13, #videCont14, #videCont15, #videCont16, #videCont17, #videCont18, #videCont19, #videCont20, #videCont21, #videCont22, #videCont23, #videCont24, #videCont25, #videCont26, #videCont27, #videCont28, #videCont29, #videCont30").css("z-index", "100002");
        $('#' + patter + '').append('<div id="closer_videopopup">&otimes;</div>');

        $("#" + settings.opener + "").on('click', function() {
            $('#' + patter + "").show();
            $('#' + settings.idvideo + '').trigger('play');

        });
        $('#' + patter + ' ' + '#closer_videopopup').on('click', function() {
            if (settings.pausevideo == true) {
                $('#' + settings.idvideo + '').trigger('pause');
            } else {
                stopVideo();
            }
            $('.alt_video').hide();
        });
        return this.css({

        });
    };

}(jQuery));