"use strict";

function ChatModel(){
    /*TODO pretty php so fix it
        add message boxes / alter message div
        make inbox - include get for second user **ask alex
        hash messages
     */

    var newPostCallBack = null, lastSeenID = -1,
        postQueue = [],
        getUUID = function () {
            var rand, millies, userID;

            if(localStorage.chat_uuid){
                localStorage.chat_uuid = localStorage.chat_uuid*1 + 1;
            }else{
                rand = Math.floor(Math.random()*10000);
                millies = (new Date()).getMilliseconds() % 100;
                userID = rand*100 + millies;

                localStorage.chat_uuid = userID * 1000;
            }
            return localStorage.chat_uuid;
        },


        updatePosts = function(){
            var http, repliesJSON, messageJSON, parameters;
            if (newPostCallBack !== null){
                http = new XMLHttpRequest();
                //parameters = "startID=" + ((lastSeenID * 1) + 1);
                http.open('GET', 'ShowPost.php');
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.onreadystatechange = function(){
                    if(http.readyState === 4 && http.status === 200){
                        repliesJSON = http.responseText.split('\n');
                        repliesJSON.forEach(function(messageTextLine){
                            //window.console.log("hey there");
                           if(messageTextLine.length >0){
                                window.console.log("Message Text: " + messageTextLine);
                                messageJSON = JSON.parse(messageTextLine);
                                //lastSeenID = messageJSON.uid;
                                newPostCallBack(messageJSON.msg);
                           }
                        });
                    }
                };
                http.send();
            }
        },

        doSendPost = function(message, uuid){
            window.console.log("Posting message: " + message);
            var http = new XMLHttpRequest(),
                params = "msg=" + encodeURIComponent(message) + "&msgID=" + getUUID();
            http.open("POST", "AddPost.php", true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = function(){
                if(http.readyState ===4&& http.status===200){
                    window.console.log("Reply: " + http.responseText);
                    if (isNaN(http.responseText*1)){
                        window.console.log("Error from server");
                    }else{
                        delete postQueue[http.responseText];
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