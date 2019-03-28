"use strict";

function ChatView(){
    var chatHistoryDiv, chatForm, postTextField;


    this.init = function(){
        chatHistoryDiv = document.getElementById("chatHistoryDiv");
        chatForm = document.getElementById("chatForm");
        postTextField = document.getElementById("messageText");
        postTextField.focus();
    };

    this.addMessage = function(message){
      var chatHistoryDiv = document.getElementById("chatHistoryDiv");
      chatHistoryDiv.innerHTML = chatHistoryDiv.innerHTML + "<p>" + message + "</p>";
    };

    this.setCallbackForMessagePost = function(callback){
        chatForm.addEventListener("submit", function(event){
            callback(postTextField.value);
            postTextField.value = "";
            postTextField.focus();
            event.preventDefault();
        });
    };

}