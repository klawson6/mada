"use strict";

function ChatModel(){


    var newPostCallBack = null, lastSeenID = -1,
        postQueue = [];

        var uniqueID = 0,

        getUUID = function () {
            uniqueID+=1;
            return uniqueID;
        },


        updatePosts = function(){
            var http, repliesJSON, messageJSON, parameters;
            if (newPostCallBack !== null){
                http = new XMLHttpRequest();
                http.open('GET', 'ShowPost.php?otherEmail=' + encodeURIComponent(otherEmail) + '&msgID=' + lastSeenID);
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.onreadystatechange = function(){
                    if(this.readyState === 4 && this.status === 200) {
                        try {
                            repliesJSON = JSON.parse(this.responseText);
                            repliesJSON.forEach(function (messageTextLine) {
                                newPostCallBack(messageTextLine.msg, messageTextLine.user1 == currentUserEmail ? 1 : 0);
                            });
                            lastSeenID = repliesJSON[repliesJSON.length - 1].msgID;
                            console.log("Last Seen ID Updated: " + lastSeenID);

                        }
                        catch (e) {
                            
                        }
                    }
                };
                http.send();
            }
        },

        doSendPost = function(message, uuid){
            window.console.log("Posting message: " + message);
            var http = new XMLHttpRequest(),
                params = "otherEmail=" + encodeURIComponent(otherEmail) + "&msg=" + encodeURIComponent(message);
            http.open("POST", "AddPost.php", true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = function(){
                console.log(this.responseText);
                if(http.readyState ===4&& http.status===200){
                    window.console.log("Reply: " + http.responseText);
                    if (isNaN(http.responseText*1)){
                        window.console.log("Error from server");
                    }else{
                        delete postQueue[uuid];
                        window.console.log("Removed item " + http.responseText);
                    }
                    window.setTimeout(updatePosts, 100);
                }
            };
            http.send(params);
        },

        checkAndSend = function(){
            var qSize = Object.keys(postQueue).length, k;
            window.console.log("Queue has " + qSize + " elements");
            if(qSize>=0){
                for(k in postQueue){
                    if (postQueue.hasOwnProperty(k)){
                        doSendPost(postQueue[k],k);
                    }
                }
            }
        };

    this.setShowNewPostCallBack = function(callback){
        newPostCallBack = callback;
    };

    this.post = function(message){
        postQueue["" + getUUID()] = message;
        setTimeout(checkAndSend, 100);
    };

    this.init = function(){
        setTimeout(updatePosts, 500);
        setInterval(updatePosts, 5000);
        setInterval(checkAndSend, 5000);
    };
}