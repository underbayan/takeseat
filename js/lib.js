function addUser(name) {
    $.ajax({
        type: "POST",
        url: encodeURI("./user.php?m=au&name=" + $("#new_user_input").val()),
        beforeSend: function () {
            waitingInfo();
        },
        success: function (data) {
            if (data == 1) {
                okinfo();
                window.location.reload(true);
            }
            else
                failinfo();
        },
        error: function () {
            failinfo();
        }
    });
}
function deleteUser(id) {
    if (confirm("你确定要删除此用户？"))
        $.ajax({
            type: "POST",
            url: encodeURI("./user.php?m=du&id=" + id),
            beforeSend: function () {
                waitingInfo('');
            },
            success: function (data) {
                //alert(data)
                if (data == 1) {
                    okinfo('');
                    window.location.reload(true);
                }
                else
                    failinfo('');
            },
            error: function () {
                failinfo('');
            }
        });
}
function resetUserPwd(id) {
    $.ajax({
        type: "POST",
        url: encodeURI("./user.php?m=ru&id=" + id),
        beforeSend: function () {
            waitingInfo('');
        },
        success: function (data) {
            if (data == 1) {
                okinfo('');
            }
            else
                failinfo('');
        },
        error: function () {
            failinfo('');
        }
    });
}
function changePwd(path, formid) {
    $.ajax({
        type: "POST",
        url: encodeURI(path),
        data: $("#" + formid).serialize(),
        beforeSend: function () {
            waitingInfo('');
        },
        success: function (data) {
            //document.write(data)
            if (data == 1) {
                okinfo('');
            }
            else
                failinfo('');
        },
        error: function () {
            failinfo('');
        }
    });
}
function updateSys(id, val) {
    $.ajax({
        type: "POST",
        url: encodeURI("./sys.php?m=us&id=" + id + "&v=" + val),
        beforeSend: function () {
            waitingInfo('');
        },
        success: function (data) {
            if (data == 1) {
                okinfo('');
                window.location.reload(true);
            }
            else
                failinfo('');
        },
        error: function () {
            failinfo('');
        }
    });
}
function addLayer() {
    $("#addLayerForm").attr("action", "./layer.php?m=al");
    $("#addLayerForm").submit();
    //window.location.reload(true);
}
function deleteLayer(id) {
    if (confirm("你确定要删除此楼层吗，删除楼层会使原有数据重置？"))
        $.ajax({
            type: "POST",
            url: encodeURI("./layer.php?m=dl&id=" + id),
            beforeSend: function () {
                waitingInfo('');
            },
            success: function (data) {
                if (data == 1) {
                    okinfo('');
                    window.location.reload(true);
                }
                else
                    failinfo('');
            },
            error: function () {
                failinfo('');
            }
        });
}
function waitingInfo($id) {
    $("#info" + $id).removeClass();
    $("#info" + $id).html("waiting...").addClass("alert well span");
}
function okinfo($id) {
    $("#info" + $id).removeClass();
    $("#info" + $id).html("ok").addClass("alert alert-success well span");
    setTimeout(function () {
        $("#info" + $id).html("").removeClass();
    }, 5000);
}
function failinfo($id) {
    $("#info" + $id).removeClass();
    $("#info" + $id).html("fail").addClass("alert alert-error well span");
    setTimeout(function () {
        $("#info" + $id).html("").removeClass();
    }, 5000);
}
function setSeatStatus(lid, o, s, id, ow, oldow) {
    o.attr("status", s);
    o.removeClass();
    o.addClass(_Pra.btnClass[s - 0]);
    $.ajax({
        type: "POST",
        url: encodeURI("./seat.php?m=ss&id=" + id + "&s=" + s + "&ow=" + ow + "&oldow=" + oldow),
        beforeSend: function () {
            waitingInfo(lid);
        },
        success: function (data) {
            //alert("./seat.php?m=ss&id="+id+"&s="+s+"&ow="+ow+"&oldow="+oldow);
            //document.write(data);
            if (data == 1)
                okinfo(lid);
            else
                failinfo(lid);
            return data;
        },
        error: function () {
            failinfo(lid);
        }
    });
}
function deleteSeat(lid, id) {
    $.ajax({
        type: "POST",
        url: encodeURI("./seat.php?m=ds&id=" + id),
        beforeSend: function () {
            waitingInfo(lid);
        },
        success: function (data) {
            if (data == 1)
                okinfo(lid);
            else
                failinfo(lid);
            return data;
        },
        error: function () {
            failinfo(lid);
        }
    });
}
function postAddSeat(lid, h, w, y, x) {
    var tmpl = lid;
    tmpl = tmpl.split("_");
    tmpl = tmpl[1];
    _Pra.postDataIsSucessful = false;
    $.ajax({
        type: "POST",
        async: false,
        url: encodeURI("./seat.php?m=as&lid=" + tmpl + "&h=" + h + "&w=" + w + "&y=" + y + "&x=" + x),
        beforeSend: function () {
            waitingInfo(lid);
        },
        success: function (data) {

            if (data == 1) {
                okinfo(lid);
                _Pra.postDataIsSucessful = true;
            }
            else
                failinfo(lid);
            return data;
        },
        error: function () {
            failinfo(lid);
        }
    });
}
function setSeatInitial() {
    conmmonInitial();
    var o = $("#userList");
    var userListTop = o.offset().top;
    $(window).scroll(function () {
        //alert($(window).scrollTop()-0+userListTop-0+'px')
        o.animate({top: $(window).scrollTop() - 0 + userListTop - 0 + 'px'},
            {duration: 600, queue: false})
    });
    //setPo
    $("button[id^='seat_']").each(
        function (key, e) {
            //console.log($(e).attr("id"));
            var o = $('#' + $(e).attr("imageId"));
            var y = o.offset().top;
            var x = o.offset().left;
            var nx = $(e).attr("px") - 0 + x;
            var ny = $(e).attr("py") - 0 + y;
            $(e).css('position', 'absolute');
            $(e).css('z-index', '99');
            $(e).css('left', nx + 'px');
            $(e).css('top', ny + 'px');
            $(e).addClass(_Pra.btnClass[$(e).attr("status") - 0]);
            //alert(o.offset().left)
            var imageid = $(e).attr('imageid');
            var seat_id = $(e).attr("id").split("_")[1];
            $(e).mousedown(function (e) {
                if (3 == e.which) {
                    if (confirm("你确定要删除座位吗？")) {
                        setSeatStatus(imageid, $(this), 0, seat_id, "", $(this).html());
                        if ($(this).html() != '') {
                            $("#userid_" + $(this).html().replace(/\./g, "\\.")).css("display", "")
                        }
                        deleteSeat(imageid, seat_id);
                        $(this).remove();
                    }
                } else if (1 == e.which) {
                    var s = ($(this).attr("status") - 0 + 1) % 3;
                    setSeatStatus(imageid, $(this), s, seat_id, "", $(this).html());

                    if ($(this).html() != '') {
                        $("#userid_" + $(this).html().replace(/\./g, "\\.")).css("display", "")
                    }
                    $(this).html("");
                }
            });
            $(e).mouseup(function (e) {
                if (_Pra.choosenUser) {
                    //console.log(_Pra.choosenUser);
                    setSeatStatus(imageid, $(this), $(this).attr("status") > 1 ? 2 : 1, seat_id, _Pra.choosenUser.attr("name"), $(this).html());
                    if ($(this).html() != '') {
                        $("#userid_" + $(this).html()).css("display", "")
                    }
                    $(this).html(_Pra.choosenUser.attr("name"));
                    _Pra.choosenUser.css("display", "none");
                    _Pra.choosenUser = null
                }
            })

        });
    $("button[id^='button_add_seat_']").each(
        function (key, e) {
            $(e).bind('click', function () {
                funAddSeatDeal($(e).attr('imageid'))
            });
        });


    $("button[id^='userid_']").each(
        function (key, user) {
            $(user).mousedown(function ($e) {
                _Pra.choosenUser = $(this);
            });
            $(user).mouseup(function ($e) {
                _Pra.choosenUser = null;
            });
        });

}

var funAddSeatDeal = function addSeat(imageid) {
    _Pra.addS = true;
    var $m = $("img[id^='image_']");
    $m.each(function (key, e) {
        $(e).unbind();
    });
    $im = $("#" + imageid);
    var tmpbtn = $('<button class=btn" style="position:absolute;display:none;width:5;height:5;z-index=99" id="tmp_button"></button>');
    $("#" + imageid + "_btnCls").append(tmpbtn);
    $im.mousedown(function ($e) {
        if (_Pra.addS) {
            _Pra.startPx = $e.pageX;
            _Pra.startPy = $e.pageY;
            _Pra.mouseDown = true;
            //console.log("mousedown");

        }
    });
    $im.mouseup(function ($ue) {
        if (!_Pra.mouseDown)return;
        var h = Math.max($ue.pageY - _Pra.startPy, 20);
        var w = Math.max($ue.pageX - _Pra.startPx, 40);
        var y = Math.max(_Pra.startPy - $im.offset().top, 0);
        var x = Math.max(_Pra.startPx - $im.offset().left, 0);
        //console.log("mouseup");
        tmpbtn.css("left", _Pra.startPx).css("top", _Pra.startPy).css("display", "block").css("width", Math.max(w, 5) + 'px').css("height", Math.max(h, 5) + 'px');
        $.when(postAddSeat(imageid, h, w, y, x)).done(
            function (r) {
                window.location.reload(true);
            });
        _Pra.mouseDown = false;
    });

    $im.mouseleave(function () {
        _Pra.mouseDown = false;
        _Pra.startPy = 0;
        _Pra.startPy = 0;
    })
}
function conmmonInitial() {
    //禁止拖动
    document.ondragstart = function () {
        return false
    };
    //禁用文本选择功能
    var omitformtags = ["input", "textarea", "select"]
    omitformtags = omitformtags.join("|")
    function disableselect(e) {
        if (omitformtags.indexOf(e.target.tagName.toLowerCase()) == -1)
            return false
    }

    function reEnable() {
        return true
    }

    if (typeof document.onselectstart != "undefined")
        document.onselectstart = new Function("return false")
    else {
        document.onmousedown = disableselect
        document.onmouseup = reEnable
    }
    //禁用右键
    $(document).ready(function () {
        $(document).bind("contextmenu", function (e) {
            return false;
        });
    });
    //重定义document 的up事件
    $(document).mouseup(function () {
        _Pra.mouseDown = false;
        _Pra.choosenUser = null;
    });
    //
    $(window).resize(function () {
        $("button[id^='seat_']").each(
            function (key, e) {
                //console.log($(e).attr("id"));
                var o = $('#' + $(e).attr("imageId"));
                var y = o.offset().top;
                var x = o.offset().left;
                var nx = $(e).attr("px") - 0 + x;
                var ny = $(e).attr("py") - 0 + y;
                $(e).css('position', 'absolute');
                $(e).css('z-index', '99');
                $(e).css('left', nx + 'px');
                $(e).css('top', ny + 'px');
                $(e).addClass(_Pra.btnClass[$(e).attr("status") - 0]);
            });
    });
}
function takeSeatInitial(username) {
    conmmonInitial();
    //setPo
    _Pra.userName = username;
    $("button[id^='seat_']").each(
        function (key, e) {
            //console.log($(e).attr("id"));
            var o = $('#' + $(e).attr("imageId"));
            var y = o.offset().top;
            var x = o.offset().left;
            var nx = $(e).attr("px") - 0 + x;
            var ny = $(e).attr("py") - 0 + y;
            $(e).css('position', 'absolute');
            $(e).css('z-index', '99');
            $(e).css('left', nx + 'px');
            $(e).css('top', ny + 'px');
            $(e).addClass(_Pra.btnClass[$(e).attr("status") - 0]);
            if ($(e).attr('status') - 0 == 0) {
                $(e).mouseup(function (e2) {
                    var imageid = $(e).attr('imageid');
                    var seat_id = $(e).attr("id").split("_")[1];
                    if (new Date().getTime() - _Pra.preClicktime > 300) {
                        _Pra.preClicktime = new Date().getTime();

                        robTheseat(imageid, seat_id, _Pra.userName);
                    }

                });
            }

        });
}
function robTheseat(lid, id, name) {
    $.ajax({
        type: "get",
        async: true,
        url: encodeURI("./robSeat.php?id=" + id + "&name=" + name),
        success: function (data) {
            //console.log(data);
            if (data != "{}" && data != "") {
                var result = jQuery.parseJSON(data);
                if (result.r == 1) {
                    okinfo(lid);
                    window.location.reload(true);
                }
                else if (result.r == 0) {
                    /*for(var tmp in result.d)
                     {
                     var tmpo=$("#seat_"+result.d[tmp].id);
                     tmpo.html(result.d[tmp].onwer)
                     tmpo.removeClass();
                     tmpo.html(result.d[tmp].owner);
                     tmpo.addClass(_Pra.btnClass[result.d[tmp].status-0]);
                     tmpo.unbind();
                     var imageid=tmpo.attr('imageid');
                     var seat_id=tmpo.attr("id").split("_")[1];
                     tmpo.mouseup(function(e2){

                     if(new Date().getTime()-_Pra.preClicktime>300)
                     {
                     _Pra.preClicktime=new Date().getTime();

                     robTheseat(imageid,seat_id,_Pra.userName);
                     }

                     });
                     }*/
                    failinfo(lid);
                    window.location.reload(true);
                }
            }
            else {
                waitingInfo(lid);
            }
        }
    });
}
function showSeatInitial() {
    conmmonInitial();
    //setPo
    $("button[id^='seat_']").each(
        function (key, e) {
            //console.log($(e).attr("id"));
            var o = $('#' + $(e).attr("imageId"));
            var y = o.offset().top;
            var x = o.offset().left;
            var nx = $(e).attr("px") - 0 + x;
            var ny = $(e).attr("py") - 0 + y;
            $(e).css('position', 'absolute');
            $(e).css('z-index', '99');
            $(e).css('left', nx + 'px');
            $(e).css('top', ny + 'px');
            $(e).addClass(_Pra.btnClass[$(e).attr("status") - 0]);
        });
}
var _Pra = {
    "addS": false, //是否开始添加作为
    "delL": false, // 是否删除楼层
    "takeS": false, //是否开始抢座
    "clickN": 0,    //单击的次数
    "ifPost": false, //是否开始发送
    "startPx": -1,
    "satatPy": -1,  //鼠标按下的位置
    "mouseDown": false,//鼠标是否按下
    "postDataIsSucessful": false,//是否发送成功
    "btnClass": ["btn-default", "btn-occupyblack", "btn-holdgray"],// 按钮的样式列表
    "choosenUser": null,
    "choosenSeat": null,
    "preClicktime": 0,
    "userName": ''
}
