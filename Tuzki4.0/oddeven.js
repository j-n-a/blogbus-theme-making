$(document).ready(function(){
    $("#comments li:odd").each(function() {
        $(this).addClass("even");
    });
});
