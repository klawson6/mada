"use strict";

function ChatModel(){


    var newPostCallBack = null, lastSeenID = 0;
    var updatePosts = function(){
        var http, repliesJSON, messageJSON, parameters;
        if (newPostCallBack !== null){
            http = new XMLHttpRequest();
            //parameters = "startID=" + ((lastSeenID * 1) + 1);
            http.open('GET', 'ShowPost.php?');
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function(){
                if(http.readyState === 4 && http.status === 200){
                    repliesJSON = http.responseText.split('\n');
                    repliesJSON.forEach(function(messageTextLine){
                       if(messageTextLine.length >0){
                            messageJSON = JSON.parse(messageTextLine);
                            lastSeenID = messageJSON.uid;
                            newPostCallBack(messageJSON.msg);

                       }
                    });
                }
            };
            http.send();
        }
    };

    this.setShowNewPostCallBack = function(callback){
        newPostCallBack = callback;
    };

    this.init = function(){
        setTimeout(updatePosts, 500);
        setInterval(updatePosts, 5000);
    };
}