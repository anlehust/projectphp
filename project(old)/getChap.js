function show(a) {
    debugger
    $.ajax({
        url: '/getChap.php' ,
        type: 'POST',
        dataType: 'text',
        data: { comic : a },
        success: function(string){
            debugger
            var arr = JSON.parse(string);
            var html="";
            arr.forEach(element=>{
                console.log(element["name_of_chap"]);
                html = html + '<option value='+element["id_chap"]+'>'+element['name_of_chap']+'</option>';
            });
            $("select#chaps").html(html);
        },
        error: function (){
            alert('Có lỗi xảy ra');
        }
    });
}
$(document).ready(show(document.getElementById("comics").value));