$(function() {
    $('#tid').keydown(function(e) {
        if (e.keyCode == 13) {
            get_ajax();
        }
    });
    $('#tpw').keydown(function(e) {
        if (e.keyCode == 13) {
            get_ajax();
        }
    });
});

function get_ajax() {
    if (!$('#tid').val()) {
        alert("아이디를 입력하세요");
        return false;
    }
    if (!$('#tpw').val()) {
        alert("비밀번호를 입력하세요");
        return false;
    }

    $.ajax({
        type: 'post',
        url: '/Ajax/get_ajax/login',
        dataType: 'json',
        data: {
            tid: $("#tid").val(),
            tpw: $('#tpw').val()
        },
        success: function(result) {
            if (result['code']) {
                location.href = "/main";
                return false;
            }

            alert(result['msg']);

            $('#top p').html("");
            $('#top').stop().fadeIn(300);
            $('#top p').append(result['msg']);

        },
        error: function(request, status, error) {
            document.write("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
        }
    });
}