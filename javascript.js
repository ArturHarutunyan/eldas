$("#subject_select").on('change', function () {
    if ($(this).val() == "ուրիշ") {
        $(this).replaceWith("<div class='a1'><input type='text' placeholder='ձեր նոր առարկան' class='form-control new_sub' name='subject'><button style='height: 27px;width: 35px;  id='back_to_sub' title='տրված առարկաներ'><i class='fa fa-arrow-left' style=' margin-top: -60px' aria-hidden='true'></i></button></div>");
    }
});
/////////////////////////////////////////////////////////////////////////
    var k = 0;
    var bool = false;
    var this_id;

$(document).on("click",".lesson_card",function () {
    if ($(window).width() > 500){
        if(k == 0 && bool == false){
            this_id = $(this).attr('id');
            t1 = setInterval(function () {
                if(k == 0 && bool == true){
                    clearInterval(t1);
                } else{
                    rotate(k);
                    if(k >= 90){
                        k = -90;
                        $("#" + this_id).hide();
                        $("#a" + this_id).show();
                        bool = true;
                    }
                    k++;
                }
            }, 2);
        }
    }else{
        this_id = $(this).attr('id');
        $("#" + this_id).hide();
        $("#a" + this_id).show();
        k=0;
        bool=true;
    }
    }
);

$(document).on("click",".back",function (){
    if ($(window).width() > 500){
    if(k==0 && bool==true){

        t2 =  setInterval(function () {
            if (k==0 && bool==false){
                clearInterval(t2);
            }else{
                rotate(k);
                if(k>=90){
                    k=-90;
                    $("#"+this_id).show();
                    $("#a"+this_id).hide();
                    bool=false;
                }
               k++;
            }
        },2);
      }
    }else{
        $("#"+this_id).show();
        $("#a"+this_id).hide();
        k = 0;
        bool=false;

    }
});

function rotate(degree) {
    $('#'+this_id).css({
        WebkitTransform:  'rotatey(' + degree + 'deg)',
        // '-webkit-transform', 'rotate('+degree+'deg)'
    });
    $('#a'+this_id).css({
        WebkitTransform: 'rotatey(' + degree + 'deg)',
        // '-webkit-transform', 'rotate('+degree+'deg)'
    });
}