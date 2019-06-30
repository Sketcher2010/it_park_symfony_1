$(document).ready(function() {
    $(".loader").fadeOut(500);
});

const showCreateModal = () => {
    $(".modal").show();
    $(".modalLoader").show();
    $.get("", {}, function(data) {
        //.........
        $(".modalLoader").hide();
    });
};
function funct1() {

}
const funct2 = function() {

};