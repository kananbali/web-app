var totalLikes = 0;
var totalUnlikes = 0;

function postReply(commentId) {
    $('#commentId').val(commentId);
    $("#comment").focus();
}

$("#submitButton").click(function () {
    $("#comment-message").css('display', 'none');
    var str = $("#frm-comment").serialize();
    if (userid == 0) {
        return;
    }
    $.ajax({
        url: "comment-add.php",
        data: str,
        type: 'post',
        success: function (response) {
            window.location.reload();
            var result = eval('(' + response + ')');
            if (response) {
                $("#comment-message").css('display', 'inline-block');
                $("#comment").val("");
                $("#commentId").val("");
                listComment();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to add comments!',
                })
                return false;
            }
        }
    });
});

$(document).ready(function () {
    listComment();
});

function listComment() {
    $.post("comment-list.php", function (data) {
        var data = JSON.parse(data);
        var comments = "";
        var replies = "";
        var item = "";
        var parent = -1;
        var results = new Array();
        var list = $("<ul class='outer-comment'>");
        var item = $("<li>").html(comments);
        for (var i = 0; (i < data.length); i++) {
            var commentId = data[i]['comment_id'];
            parent = data[i]['parent_comment_id'];
            var obj = getLikesUnlikes(commentId);
            if (parent == "0") {
                if (data[i]['like_unlike'] >= 1) {
                    like_icon = "<img src='assets/images/like.png' id='unlike_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",-1)' />";
                    like_icon += "<img style='display:none;' src='assets/images/unlike.png' id='like_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",1)' />";
                } else {
                    like_icon = "<img style='display:none;' src='assets/images/like.png' id='unlike_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",-1)' />";
                    like_icon += "<img src='assets/images/unlike.png' id='like_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",1)' />";
                }
                var d = new Date(data[i]['date'].replace(/-/g, '/'));
                let ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(d);
                let mo = new Intl.DateTimeFormat('en', {month: 'short'}).format(d);
                let da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(d);
                // console.log(`${da}-${mo}-${ye}`);
                comments = "\ <div class='comment-row'>\ <div class='comment-info'>\ <span class='commet-row-label'>from</span>\ <span class='posted-by'>" + data[i]['comment_sender_name'] + "</span>\ <span class='commet-row-label'>at</span> \ <span class='posted-at'>" + `${da}-${mo}-${ye}` + "</span>\ </div>\ <div class='comment-text'>" + data[i]['comment'] + "</div>\ <div>\ <a class='btn-reply' onClick='postReply(" + commentId + ")'>Reply</a>\ </div>\ <div class='post-action'>\ " + like_icon + "&nbsp;\ <span id='likes_" + commentId + "'> " + totalLikes + " likes </span>\ </div>\ </div>";
                var item = $("<li>").html(comments);
                list.append(item);
                var reply_list = $('<ul>');
                item.append(reply_list);
                listReplies(commentId, data, reply_list);
            }
        }
        $("#output").html(list);
    });
}

function listReplies(commentId, data, list) {

    for (var i = 0; (i < data.length); i++) {

        var obj = getLikesUnlikes(data[i].comment_id);
        if (commentId == data[i].parent_comment_id) {
            if (data[i]['like_unlike'] >= 1) {
                like_icon = "<img src='assets/images/like.png' id='unlike_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",-1)' />";
                like_icon += "<img style='display:none;' src='assets/images/unlike.png' id='like_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",1)' />";

            } else {
                like_icon = "<img style='display:none;' src='assets/images/like.png' id='unlike_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",-1)' />";
                like_icon += "<img src='assets/images/unlike.png' id='like_" + data[i]['comment_id'] + "' class='like-unlike' onClick='likeOrDislike(" + data[i]['comment_id'] + ",1)' />";

            }
            var d = new Date(data[i]['date'].replace(/-/g, '/'));
            let ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(d);
            let mo = new Intl.DateTimeFormat('en', {month: 'short'}).format(d);
            let da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(d);
            var comments = "\ <div class='comment-row' > \ <div class='comment-info' > \ <span class='commet-row-label' > from</span > \ <span class='posted-by' > " + data[i]['comment_sender_name'] + "</span > \ <span class='commet-row-label' > at</span > \ <span class='posted-at' > " + `${da}-${mo}-${ye}` + "</span > \ </div > \ <div class='comment-text' > " + data[i]['comment'] + "</div > \ <div > \ <a class='btn-reply' onClick='postReply(" + data[i]['comment_id'] + ")' > Reply</a > \ </div > \ <div class='post-action' > " + like_icon + " &nbsp;\ <span id='likes_" + data[i]['comment_id'] + "' > " + totalLikes + " likes </span > \ </div > \ </div > ";

            var item = $("<li>").html(comments);
            var reply_list = $('<ul>');
            list.append(item);
            item.append(reply_list);
            listReplies(data[i].comment_id, data, reply_list);
        }
    }
}

function getLikesUnlikes(commentId) {

    $.ajax({
        type: 'POST',
        async: false,
        url: 'get-like-unlike.php',
        data: {
            comment_id: commentId
        },
        success: function (data) {
            totalLikes = data;
        }
    });

}


function likeOrDislike(comment_id, like_unlike) {

    $.ajax({
        url: 'comment-like-unlike.php',
        async: false,
        type: 'post',
        data: {
            comment_id: comment_id,
            like_unlike: like_unlike
        },
        dataType: 'json',
        success: function (data) {
            $("#likes_" + comment_id).text(data + " likes");
            if (like_unlike == 1) {
                $("#like_" + comment_id).css("display", "none");
                $("#unlike_" + comment_id).show();
            }
            if (like_unlike == -1) {
                $("#unlike_" + comment_id).css("display", "none");
                $("#like_" + comment_id).show();
            }
        },
        error: function (data) {
            Swal.fire({
                html: '<iframe height="625" width="375" loading="lazy" id="loginframe" style="margin:0 auto" src="../login/login_modal.php?popup=1" title="Login"></iframe>',
                showCancelButton: false,
                showCloseButton: false,
                showConfirmButton: false,
                width: 375


            })
            $("#loginframe").on('load', function () { // console.log('loaded');
                if ($(this).contents()[0].location.pathname == "/login/loginsuccess.php") { // console.log('logged in');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                }

            });
        }
    });
}
