$(document).on('click','#btn-add',function(e) {
    var data = $("#user_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "backend/savekandang.php",
        success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    $('#addFarmModal').modal('hide');
                    alert('Data Berhasil Ditambahkan !'); 
                    location.reload();						
                }
                else if(dataResult.statusCode==201){
                alert(dataResult);
                }
        }
    });
});

$(document).on('click','.update',function(e) {
    var id=$(this).attr("data-id");
    var kd_peternak=$(this).attr("data-kd_peternak");
    var tgl=$(this).attr("data-tgl");
    var waktu=$(this).attr("data-waktu");
    var suhu_1=$(this).attr("data-suhu_1");
    var kelembapan_1=$(this).attr("data-kelembapan_1");
    var suhu_2=$(this).attr("data-suhu_2");
    var kelembapan_2=$(this).attr("data-kelembapan_2");
    var suhu_3=$(this).attr("data-suhu_3");
    var kelembapan_3=$(this).attr("data-kelembapan_3");
    var jml_ayam=$(this).attr("data-jml_ayam");
    var foto_ayam=$(this).attr("data-foto_ayam");
    $('#id_u').val(id);
    $('#kd_peternak_u').val(kd_peternak);
    $('#tgl_u').val(tgl);
    $('#waktu_u').val(waktu);
    $('#suhu_1_u').val(suhu_1);
    $('#kelembapan_1_u').val(kelembapan_1);
    $('#suhu_2_u').val(suhu_2);
    $('#kelembapan_2_u').val(kelembapan_2);
    $('#suhu_3_u').val(suhu_3);
    $('#kelembapan_3_u').val(kelembapan_3);
    $('#jml_ayam_u').val(jml_ayam);
    $('#foto_ayam_u').val(foto_ayam);
});

$(document).on('click','#update',function(e) {
    var data = $("#update_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "backend/savekandang.php",
        success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    $('#editFarmModal').modal('hide');
                    alert('Data Berhasil Diedit !'); 
                    location.reload();						
                }
                else if(dataResult.statusCode==201){
                   alert(dataResult);
                }
        }
    });
});$(document).on("click", ".delete", function() { 
    var id=$(this).attr("data-id");
    $('#id_d').val(id);
    
});
$(document).on("click", "#delete", function() { 
    $.ajax({
        url: "backend/savekandang.php",
        type: "POST",
        cache: false,
        data:{
            type:3,
            id: $("#id_d").val()
        },
        success: function(dataResult){
                $('#deleteFarmModal').modal('hide');
                $("#"+dataResult).remove();
        
        }
    });
});
$(document).on("click", "#delete_multiple", function() {
    var user = [];
    $(".user_checkbox:checked").each(function() {
        user.push($(this).data('user-id'));
    });
    if(user.length <=0) {
        alert("Please select records."); 
    } 
    else { 
        WRN_PROFILE_DELETE = "Are you sure you want to delete "+(user.length>1?"these":"this")+" row?";
        var checked = confirm(WRN_PROFILE_DELETE);
        if(checked == true) {
            var selected_values = user.join(",");
            console.log(selected_values);
            $.ajax({
                type: "POST",
                url: "backend/savekandang.php",
                cache:false,
                data:{
                    type: 4,						
                    id : selected_values
                },
                success: function(response) {
                    var ids = response.split(",");
                    for (var i=0; i < ids.length; i++ ) {	
                        $("#"+ids[i]).remove(); 
                    }	
                } 
            }); 
        }  
    } 
});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function(){
        if(this.checked){
            checkbox.each(function(){
                this.checked = true;                        
            });
        } else{
            checkbox.each(function(){
                this.checked = false;                        
            });
        } 
    });
    checkbox.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });
});
